<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Jam;
use App\Models\MataKuliah;
use App\Models\NamaDosen;
use App\Models\PeminjamanRuang;
use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Models\Ruang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanRuangController extends Controller
{
    public function index(Request $request)
    {
        $data = PeminjamanRuang::with(['Prodi', 'Angkatan', 'Ruang', 'Matkul', 'Dosen', 'Jamx', 'Jamy'])->get();
        $title = 'Delete Peminjaman Ruangan!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        if (auth()->user()->type == '1') {
            return view('admin/peminjaman-ruang/index', [
                'title' => 'Data Peminjaman Ruang',
                'data' => $data
            ]);
        } else {
            $query = PeminjamanRuang::with(['Prodi', 'Angkatan', 'Ruang', 'Matkul', 'Dosen', 'Jamx', 'Jamy'])
                ->where('nama_peminjam', auth()->user()->name);

            if ($request->has('cari')) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_peminjam', 'LIKE', '%' . $request->cari . '%')
                        ->orWhere('nama_peminjam', 'LIKE', '%' . $request->cari . '%');
                });
            }

            // if ($request->has('cari')) {
            //     $data = PeminjamanRuang::where('nama_peminjam', 'LIKE', '%' . $request->cari . '%')->get();
            // } else {
            //     $data = PeminjamanRuang::all();
            // }

            $data = $query->get();
            // dd($prodi);
            return view('user/data/peminjamanruang', [
                'data' => $data
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
        return view('admin/peminjaman-ruang/create', [
            'title' => 'Tambah Peminjaman ruang',
            'ruang' => $ruang,
            'prodi' => $prodi,
            'jam_mulai' => $jam,
            'jam_selesai' => $jam,
            'matkul' => $matkul,
            'dosen' => $dosen,
            'angkatan' => $angkatan,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_peminjam' => ['required'],
            'tgl_peminjaman' => ['required'],
            'ruang_id' => ['required'],
            'matkul_id' => ['required'],
            'dosen_id' => ['required'],
            'jam_mulai_id' => ['required'],
            'jam_selesai_id' => ['required'],
            'prodi_id' => ['required'],
            'angkatan_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil jam mulai dan jam selesai dari tabel jam
        $jamMulai = Jam::find($request->jam_mulai_id);
        $jamSelesai = Jam::find($request->jam_selesai_id);

        // ======================
        // CEK BENTROK PINJAMAN
        // ======================
        $cekBentrokPeminjaman = PeminjamanRuang::where('tgl_peminjaman', $request->tgl_peminjaman)
            ->where('ruang_id', $request->ruang_id)
            ->where('status_peminjaman', '!=', 2)
            ->whereHas('Jamx', function ($q) use ($jamSelesai) {
                $q->where('jam', '<', $jamSelesai->jam);
            })
            ->whereHas('Jamy', function ($q) use ($jamMulai) {
                $q->where('jam', '>', $jamMulai->jam);
            })
            ->exists();

        if ($cekBentrokPeminjaman) {
            if (auth()->user()->type == '1') {
                Alert::error('Jadwal Bentrok', 'Ruangan sudah digunakan di jam tersebut (jadwal peminjaman).');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Jadwal Bentrok',
                        'text' => 'Ruangan sudah digunakan di jam tersebut (jadwal peminjaman).',
                        'icon' => 'error'
                    ]);
            }
        }

        // ==========================
        // CEK BENTROK JADWAL TETAP
        // ==========================
        $hari = strtolower(Carbon::parse($request->tgl_peminjaman)->isoFormat('dddd'));

        $cekBentrokJadwalTetap = \App\Models\JadwalRuangan::where('hari', $hari)
            ->where('ruang_id', $request->ruang_id)
            ->whereHas('Jamx', function ($q) use ($jamSelesai) {
                $q->where('jam', '<', $jamSelesai->jam);
            })
            ->whereHas('Jamy', function ($q) use ($jamMulai) {
                $q->where('jam', '>', $jamMulai->jam);
            })
            ->exists();

        if ($cekBentrokJadwalTetap) {
            if (auth()->user()->type == '1') {
                Alert::error('Jadwal Bentrok', 'Ruangan sudah digunakan di jam tersebut (jadwal peminjaman');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Jadwal Bentrok',
                        'text' => 'Ruangan sudah digunakan di jam tersebut (jadwal peminjaman).',
                        'icon' => 'error'
                    ]);
            }
        }

        // ==========================
        // CEK JAM
        // ==========================
        if (strtotime($jamMulai->jam) >= strtotime($jamSelesai->jam)) {
            if (auth()->user()->type == '1') {
                Alert::error('Waktu Tidak Valid', 'Jam mulai harus lebih awal dari jam selesai.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Waktu Tidak Valid',
                        'text' => 'Jam mulai harus lebih awal dari jam selesai.',
                        'icon' => 'error'
                    ]);
            }
        }

        // ==========================
        // CEK HARI PEMINJAMAN
        // ==========================
        if (Carbon::parse($request->tgl_peminjaman)->isBefore(Carbon::today())) {
            if (auth()->user()->type == '1') {
                Alert::error('Tanggal Tidak Valid', 'Peminjaman hanya bisa dilakukan untuk hari ini atau setelahnya.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Tanggal Tidak Valid',
                        'text' => 'Peminjaman hanya bisa dilakukan untuk hari ini atau setelahnya.',
                        'icon' => 'error'
                    ]);
            }
        }

        // ==========================
        // CEK JAM OPERASIONAL
        // ==========================
        $jamOperasionalMulai = strtotime('07:30:00');
        $jamOperasionalSelesai = strtotime('19:00:00');

        if (
            strtotime($jamMulai->jam) < $jamOperasionalMulai ||
            strtotime($jamSelesai->jam) > $jamOperasionalSelesai
        ) {
            if (auth()->user()->type == '1') {
                Alert::error('Diluar Jam Operasional', 'Jam peminjaman hanya boleh antara pukul 07:30 sampai 19:00.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Diluar Jam Operasional',
                        'text' => 'Jam peminjaman hanya boleh antara pukul 07:30 sampai 19:00.',
                        'icon' => 'error'
                    ]);
            }
        }

        // =====================
        // JIKA AMAN, SIMPAN DATA
        // =====================
        PeminjamanRuang::create($request->all());

        Alert::success('Berhasil', 'Peminjaman Ruangan Berhasil Ditambahkan');

        if (auth()->user()->type == '1') {
            return redirect()->route('peminjaman-ruang.index')
                ->with('success', 'Peminjaman berhasil ditambahkan!');
        } else {
            return redirect()->route('user.home')->with('success', 'Peminjaman berhasil ditambahkan!');
        }

        // return redirect(auth()->user()->type == '1' ? route('peminjaman-ruang.index') : route('user.home'))
        //     ->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ruang = Ruang::all();
        $prodi = Prodi::all();
        $matkul = MataKuliah::all();
        $dosen = NamaDosen::all();
        $jam = Jam::all();
        $angkatan = Angkatan::all();
        $data = PeminjamanRuang::findOrFail($id);
        return view('admin/peminjaman-ruang/edit', [
            'title' => 'Ubah Peminjaman Ruang',
            'ruang' => $ruang,
            'prodi' => $prodi,
            'matkul' => $matkul,
            'dosen' => $dosen,
            'jam' => $jam,
            'angkatan' => $angkatan,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_peminjam' => 'required',
            'tgl_peminjaman' => 'required',
            'ruang_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'jam_mulai_id' => 'required',
            'jam_selesai_id' => 'required',
            'prodi_id' => 'required',
            'angkatan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jamMulai = Jam::find($request->jam_mulai_id);
        $jamSelesai = Jam::find($request->jam_selesai_id);
        $tgl = $request->tgl_peminjaman;

        // ======================
        // CEK BENTROK PEMINJAMAN (kecuali ID sendiri)
        // ======================
        $cekBentrokPeminjaman = PeminjamanRuang::where('id', '!=', $id)
            ->where('tgl_peminjaman', $tgl)
            ->where('ruang_id', $request->ruang_id)
            ->where('status_peminjaman', '!=', 2)
            ->whereHas('Jamx', fn($q) => $q->where('jam', '<', $jamSelesai->jam))
            ->whereHas('Jamy', fn($q) => $q->where('jam', '>', $jamMulai->jam))
            ->exists();

        if ($cekBentrokPeminjaman) {
            Alert::error('Jadwal Bentrok', 'Ruangan sudah digunakan di jam tersebut (jadwal peminjaman).');
            return redirect()->back()->withInput();
        }

        // ======================
        // CEK BENTROK JADWAL TETAP
        // ======================
        $hari = strtolower(Carbon::parse($tgl)->isoFormat('dddd'));
        $cekBentrokJadwalTetap = \App\Models\JadwalRuangan::where('hari', $hari)
            ->where('ruang_id', $request->ruang_id)
            ->whereHas('Jamx', fn($q) => $q->where('jam', '<', $jamSelesai->jam))
            ->whereHas('Jamy', fn($q) => $q->where('jam', '>', $jamMulai->jam))
            ->exists();

        if ($cekBentrokJadwalTetap) {
            Alert::error('Jadwal Bentrok', 'Ruangan sudah digunakan di jam tersebut (jadwal tetap).');
            return redirect()->back()->withInput();
        }

        // ==========================
        // CEK JAM
        // ==========================
        if (strtotime($jamMulai->jam) >= strtotime($jamSelesai->jam)) {
            if (auth()->user()->type == '1') {
                Alert::error('Waktu Tidak Valid', 'Jam mulai harus lebih awal dari jam selesai.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Waktu Tidak Valid',
                        'text' => 'Jam mulai harus lebih awal dari jam selesai.',
                        'icon' => 'error'
                    ]);
            }
        }

        // ==========================
        // CEK HARI PEMINJAMAN
        // ==========================
        if (Carbon::parse($request->tgl_peminjaman)->isBefore(Carbon::today())) {
            if (auth()->user()->type == '1') {
                Alert::error('Tanggal Tidak Valid', 'Peminjaman hanya bisa dilakukan untuk hari ini atau setelahnya.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Tanggal Tidak Valid',
                        'text' => 'Peminjaman hanya bisa dilakukan untuk hari ini atau setelahnya.',
                        'icon' => 'error'
                    ]);
            }
        }

        // ==========================
        // CEK JAM OPERASIONAL
        // ==========================
        $jamOperasionalMulai = strtotime('07:30:00');
        $jamOperasionalSelesai = strtotime('19:00:00');

        if (
            strtotime($jamMulai->jam) < $jamOperasionalMulai ||
            strtotime($jamSelesai->jam) > $jamOperasionalSelesai
        ) {
            if (auth()->user()->type == '1') {
                Alert::error('Diluar Jam Operasional', 'Jam peminjaman hanya boleh antara pukul 07:30 sampai 19:00.');
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', [
                        'title' => 'Diluar Jam Operasional',
                        'text' => 'Jam peminjaman hanya boleh antara pukul 07:30 sampai 19:00.',
                        'icon' => 'error'
                    ]);
            }
        }

        // =====================
        // UPDATE JIKA AMAN
        // =====================
        $data = PeminjamanRuang::findOrFail($id);
        $data->update($request->all());

        Alert::success('Berhasil', 'Peminjaman Ruangan Berhasil Diubah');

        return redirect()->route('peminjaman-ruang.index')
            ->with('success', 'Peminjaman berhasil diubah!');
    }


    public function destroy($id)
    {
        $data = PeminjamanRuang::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Peminjaman Berhasil Dihapus');

        return redirect()->route('peminjaman-ruang.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $data = PeminjamanRuang::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'status_peminjaman' => 'required|in:1,2'
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', 'Status tidak valid.');
            return redirect()->back();
        }

        $data->update([
            'status_peminjaman' => $request->status_peminjaman
        ]);

        $statusText = $request->status_peminjaman == 1 ? 'disetujui' : 'ditolak';
        Alert::success('Berhasil', "Peminjaman berhasil $statusText!");

        return redirect()->route('peminjaman-ruang.index')
            ->with('success', "Peminjaman berhasil $statusText!");
    }
}
