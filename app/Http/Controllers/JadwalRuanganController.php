<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JadwalRuangan;
use App\Http\Requests\StoreJadwalRuanganRequest;
use App\Http\Requests\UpdateJadwalRuanganRequest;
use App\Models\Angkatan;
use App\Models\Jam;
use App\Models\MataKuliah;
use App\Models\NamaDosen;
use App\Models\PeminjamanRuang;
use App\Models\Prodi;
use App\Models\Ruang;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalRuanganController extends Controller
{
    public function index()
    {
        $data = JadwalRuangan::with(['Prodi', 'Angkatan', 'Ruang', 'Matkul', 'Dosen', 'Jamx', 'Jamy'])->get();
        // dd($data);
        $title = 'Delete Jadwal Ruangan!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/jadwal-ruangan/index', [
            'title' => 'Data Jadwal Ruangan',
            'data' => $data
        ]);
    }

    public function viewindex()
    {
        $filterHari = request('hari');
        $filterRuang = request('ruang');

        $jadwal = JadwalRuangan::with(['Ruang', 'Dosen', 'Matkul', 'Prodi', 'Angkatan', 'Jamx', 'Jamy'])
            ->when($filterHari, fn($q) => $q->where('hari', $filterHari))
            ->when($filterRuang, function ($q) use ($filterRuang) {
                $q->whereHas('Ruang', fn($r) => $r->where('nama_ruang', $filterRuang));
            })
            ->get();

        $jamHeaders = [
            '07:30',
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '12:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:00',
        ];

        $ruanganList = [
            'GDS 508',
            'GDS 512',
            'GDS 514',
            'GDS 515',
            'GDS 507',
            'GDS 517',
            'GDS 607',
            'GDS 608',
            'GDS 613',
            'GDS 614',
        ];

        $matrix = [];

        // Inisialisasi matrix kosong
        foreach ($ruanganList as $ruang) {
            if ($filterRuang && $filterRuang !== $ruang) continue; // filter hanya ruangan terpilih
            foreach ($jamHeaders as $jam) {
                $matrix[$ruang][$jam] = '-';
            }
        }

        // Isi matrix berdasarkan data jadwal
        foreach ($jadwal as $d) {
            $hari = strtolower($d->hari);
            if ($filterHari && strtolower($filterHari) !== $hari) continue;

            $startTime = substr($d->jamx['jam'], 0, 5);
            $endTime = substr($d->jamy['jam'], 0, 5);
            $ruangNama = $d->ruang['nama_ruang'] ?? null;

            if (!$ruangNama || !isset($matrix[$ruangNama])) continue;

            $prodiMap = [
                'Ilmu Komputer' => 'Ilkom',
                'Pendidikan Matematika' => 'PM',
                'Matematika' => 'Mat',
                'Statistika' => 'Stat',
            ];

            $prodiFull = $d->prodi['nama_prodi'] ?? '-';
            $prodi = $prodiMap[$prodiFull] ?? $prodiFull;
            $angkatan = substr($d->angkatan['angkatan'], -2);
            $matkul =  $d->matkul['mata_kuliah'] ?? '-';
            $dosenInisial = $d->dosen['nama_dosen'] ?? '-';

            $label = "$prodi'$angkatan - $matkul ($dosenInisial)";

            $current = $startTime;
            while ($current < $endTime) {
                $matrix[$ruangNama][$current] = $label;
                $time = \Carbon\Carbon::createFromFormat('H:i', $current)->addMinutes(30);
                $current = $time->format('H:i');
            }
        }

        if (auth()->user()->type == '1') {
            return view('admin/jadwal-ruangan/view', [
                'title' => 'Jadwal Ruangan',
                'matrix' => $matrix,
                'jamHeaders' => $jamHeaders,
                'ruanganList' => $ruanganList,
            ]);
        } else {
            // dd($ruanganList);
            return view('user/kalender/view', [
                'title' => 'Jadwal Ruangan',
                'matrix' => $matrix,
                'jamHeaders' => $jamHeaders,
                'ruanganList' => $ruanganList,
            ]);
        }
    }

    public function create()
    {
        $prodi = Prodi::all();
        $ruang = Ruang::all();
        $jam = Jam::all();
        $matkul = MataKuliah::all();
        $dosen =  NamaDosen::all();
        $angkatan = Angkatan::all();
        return view('admin/jadwal-ruangan/create', [
            'title' => 'Tambah Data Jadwal Ruangan',
            'prodi' => $prodi,
            'ruang' => $ruang,
            'jam_mulai' => $jam,
            'jam_selesai' => $jam,
            'matkul' => $matkul,
            'dosen' => $dosen,
            'angkatan' => $angkatan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id' => ['required', 'max:100'],
            'matkul_id' => ['required'],
            'dosen_id' => ['required'],
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'jam_mulai_id' => ['required'],
            'jam_selesai_id' => ['required'],
            'prodi_id' => ['required'],
            'angkatan_id' => ['required'],
            'status_ruang' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect('jadwal-ruangan/tambah')
                ->withErrors($validator)
                ->withInput();
        }

        $jamMulai = Jam::find($request->jam_mulai_id);
        $jamSelesai = Jam::find($request->jam_selesai_id);
    //     if ($jamMulai->jam == $jamSelesai->jam) {
    //     Alert::error('Jam Tidak Valid', 'Jam mulai harus lebih kecil dari jam selesai.');
    //     return redirect()->back()->withInput();
    // }

        $cekBentrok = JadwalRuangan::where('hari', $request->hari)
            ->where('ruang_id', $request->ruang_id)
            ->whereHas('Jamx', function ($q) use ($jamSelesai) {
                $q->where('jam', '<', $jamSelesai->jam);
            })
            ->whereHas('Jamy', function ($q) use ($jamMulai) {
                $q->where('jam', '>', $jamMulai->jam);
            })
            ->exists();

        if ($cekBentrok) {
            Alert::error('Jadwal Bentrok', 'Ruangan sudah digunakan di jam tersebut.');
            return redirect()->back()->withInput();
        }

        $validated = $validator->validated();
        JadwalRuangan::create($validated);

        Alert::success('Berhasil', 'Jadwal Ruangan Berhasil Ditambahkan');

        return redirect()->route('jadwal-ruangan.index')->with('success', 'Jadwal Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $prodi = Prodi::all();
        $matkul = MataKuliah::all();
        $dosen = NamaDosen::all();
        $ruang = Ruang::all();
        $jam = Jam::all();
        $angkatan = Angkatan::all();
        $data = JadwalRuangan::findOrFail($id);
        return view('admin/jadwal-ruangan/edit', [
            'title' => 'Edit Data Jadwal Ruangan',
            'prodi' => $prodi,
            'matkul' => $matkul,
            'dosen' => $dosen,
            'ruang' => $ruang,
            'jam' => $jam,
            'angkatan' => $angkatan,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruang_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai_id' => 'required',
            'jam_selesai_id' => 'required',
            'prodi_id' => 'required',
            'angkatan_id' => 'required',
            'status_ruang' => 'required'
        ]);

        $jamMulai = Jam::find($request->jam_mulai_id);
        $jamSelesai = Jam::find($request->jam_selesai_id);
        // if ($jamMulai->jam == $jamSelesai->jam) {
        //     dd("paldinh");
        //     Alert::error('Jam Tidak Valid', 'Jam mulai harus lebih kecil dari jam selesai.');
        //     return dd("mandi");
        // }
        

        $cekBentrok = JadwalRuangan::where('hari', $request->hari)
            ->where('ruang_id', $request->ruang_id)
            ->where('id', '!=', $id) // pengecualian data yang sedang diupdate
            ->whereHas('Jamx', function ($q) use ($jamSelesai) {
                $q->where('jam', '<', $jamSelesai->jam);
            })
            ->whereHas('Jamy', function ($q) use ($jamMulai) {
                $q->where('jam', '>', $jamMulai->jam);
            })
            ->exists();

        if ($cekBentrok) {
            Alert::error('Jadwal Bentrok', 'Ruangan sudah digunakan di jam tersebut.');
            return redirect()->back()->withInput();
        }

        JadwalRuangan::where('id', $id)
            ->update([
                'ruang_id' => $request->ruang_id,
                'matkul_id' => $request->matkul_id,
                'dosen_id' => $request->dosen_id,
                'hari' => $request->hari,
                'jam_mulai_id' => $request->jam_mulai_id,
                'jam_selesai_id' => $request->jam_selesai_id,
                'prodi_id' => $request->prodi_id,
                'angkatan_id' => $request->angkatan_id,
            ]);

        $data = JadwalRuangan::find($id);

        if ($request->status_peminjaman == 1) {
            $temp = Ruang::where('id', $request->id);
            $temp->update([
                'status_ruang' => 1
            ]);
        } else {
            $temp = Ruang::where('id', $request->id);
            $temp->update([
                'status_ruang' => 0
            ]);
        }
        $data->update($request->all());


        Alert::success('Berhasil', 'Jadwal Ruangan Berhasil Diubah');

        return redirect()->route('jadwal-ruangan.index')
            ->with('success', 'Jadwal Ruangan berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = JadwalRuangan::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Jadwal Ruangan Berhasil Dihapus');

        return redirect()->route('jadwal-ruangan.index')
            ->with('success', 'Jadwal Ruangan berhasil dihapus!');
    }

    // public function viewCalendar(Request $request)
    // {
    //     $filterRuang = $request->ruang;

    //     $jadwal = JadwalRuangan::with(['Ruang', 'Dosen', 'Matkul', 'Prodi', 'Angkatan', 'Jamx', 'Jamy'])
    //         ->when($filterRuang, function ($q) use ($filterRuang) {
    //             $q->whereHas('Ruang', fn($r) => $r->where('nama_ruang', $filterRuang));
    //         })
    //         ->get();

    //     // AMBIL daftar ruangan unik dari jadwal
    //     $ruanganList = JadwalRuangan::with('Ruang')
    //         ->get()
    //         ->pluck('ruang.nama_ruang')
    //         ->unique()
    //         ->filter()
    //         ->sort()
    //         ->values();

    //     $events = [];

    //     $dayMap = [
    //         'senin' => 'monday',
    //         'selasa' => 'tuesday',
    //         'rabu' => 'wednesday',
    //         'kamis' => 'thursday',
    //         'jumat' => 'friday',
    //         'sabtu' => 'saturday',
    //         'minggu' => 'sunday',
    //     ];

    //     foreach ($jadwal as $j) {
    //         $hari = strtolower($j->hari);
    //         $dayMap = [
    //             'senin' => 1,
    //             'selasa' => 2,
    //             'rabu' => 3,
    //             'kamis' => 4,
    //             'jumat' => 5,
    //             'sabtu' => 6,
    //             'minggu' => 0,
    //         ];

    //         $events[] = [
    //             'title' => $j->matkul->mata_kuliah,
    //             'daysOfWeek' => [$dayMap[$hari]],
    //             'startTime' => substr($j->jamx->jam, 0, 5),
    //             'endTime' => substr($j->jamy->jam, 0, 5),
    //             'startRecur' => now()->startOfMonth()->toDateString(),
    //             'endRecur' => now()->addMonths(1)->endOfMonth()->toDateString(),
    //         ];
    //     }

    //     return view('user/kalender/kalender', [
    //         'events' => $events,
    //         'ruanganList' => Ruang::all(),
    //         'prodi' => Prodi::all(),
    //         'matkul' => MataKuliah::all(),
    //         'jam_mulai' => Jam::all(),
    //         'jam_selesai' => Jam::all(),
    //         'angkatan' => Angkatan::all(),
    //         'matkul' => MataKuliah::all(),
    //         'dosen' => NamaDosen::all(),
    //         'ruang' => Ruang::all(),
    //     ]);
    // }

    public function viewCalendar(Request $request)
    {
        $filterRuang = $request->ruang;

        // Ambil jadwal tetap
        $jadwal = JadwalRuangan::with(['Ruang', 'Dosen', 'Matkul', 'Prodi', 'Angkatan', 'Jamx', 'Jamy'])
            ->when($filterRuang, fn($q) => $q->whereHas('Ruang', fn($r) => $r->where('nama_ruang', $filterRuang)))
            ->get();

        // Ambil peminjaman ruangan
        $peminjaman = PeminjamanRuang::with(['Ruang', 'Jamx', 'Jamy', 'Matkul'])
            ->when($filterRuang, fn($q) => $q->whereHas('Ruang', fn($r) => $r->where('nama_ruang', $filterRuang)))
            ->get();

        // Ruangan untuk filter dan form
        $ruanganList = Ruang::all();

        $events = [];

        // Jadwal Ruangan
        $dayMap = [
            'senin' => 1,
            'selasa' => 2,
            'rabu' => 3,
            'kamis' => 4,
            'jumat' => 5,
            'sabtu' => 6,
            'minggu' => 0,
        ];

        foreach ($jadwal as $j) {
            $hari = strtolower($j->hari);
            $events[] = [
                'title' => $j->matkul->mata_kuliah ?? 'Jadwal Tetap',
                'daysOfWeek' => [$dayMap[$hari]],
                'startTime' => substr($j->jamx->jam, 0, 5),
                'endTime' => substr($j->jamy->jam, 0, 5),
                'startRecur' => now()->startOfMonth()->toDateString(),
                'endRecur' => now()->addMonths(1)->endOfMonth()->toDateString(),
                'color' => '#3788d8' // biru: jadwal tetap
            ];
        }

        // Peminjaman Ruangan (non-recurrence, langsung tanggal)
        foreach ($peminjaman as $p) {
            $events[] = [
                'title' => 'Matkul Pengganti: ' . ($p->matkul->mata_kuliah ?? 'Kegiatan'),
                'start' => $p->tgl_peminjaman . 'T' . substr($p->jamx->jam, 0, 5),
                'end' => $p->tgl_peminjaman . 'T' . substr($p->jamy->jam, 0, 5),
                'color' => '#dc3545', // merah: peminjaman
            ];
        }

        return view('user.kalender.kalender', [
            'events' => $events,
            'ruanganList' => $ruanganList,
            'prodi' => Prodi::all(),
            'matkul' => MataKuliah::all(),
            'jam_mulai' => Jam::all(),
            'jam_selesai' => Jam::all(),
            'angkatan' => Angkatan::all(),
            'dosen' => NamaDosen::all(),
            'ruang' => Ruang::all(),
        ]);
    }

    public function destroyAll()
    {
        JadwalRuangan::query()->delete();

        Alert::success('Berhasil', 'Semua Jadwal Berhasil Dihapus');

        return redirect()->route('jadwal-ruangan.index')
            ->with('success', 'Semua Jadwal berhasil dihapus!');
    }
}
