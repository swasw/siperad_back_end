<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Barang;
use App\Models\Feedback;
use App\Models\JadwalRuangan;
use App\Models\Jam;
use App\Models\MataKuliah;
use App\Models\NamaDosen;
use App\Models\PeminjamanBarang;
use App\Models\PeminjamanRuang;
use App\Models\Prodi;
use App\Models\Ruang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class FunctionAPIController extends Controller
{
    // GET /api/alat
    public function indexAlat()
    {
        $data = Barang::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    // POST /api/alat
    public function storeAlat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => ['required', 'max:100'],
            'deskripsi_barang' => ['required', 'max:100'],
            'status_barang' => ['required'],
            'stok' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Barang::create($validator->validated());

        return response()->json(['message' => 'Alat created successfully'], 201);
    }

    // GET /api/alat/{id}
    public function getAlat($id)
    {
        $data = Barang::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    // PUT /api/alat/{id}
    public function updateAlat(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => ['required', 'max:100'],
            'deskripsi_barang' => ['required', 'max:100'],
            'status_barang' => ['required'],
            'stok' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = Barang::find($id);
        if (!$data) {
            return response()->json(['message' => 'Alat not found'], 404);
        }

        $data->update($validator->validated());

        return response()->json(['message' => 'Alat updated successfully'], 200);
    }

    // DELETE /api/alat/{id}
    public function destroyAlat($id)
    {
        $data = Barang::find($id);

        if (!$data) {
            return response()->json(['message' => 'Alat not found'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Alat deleted successfully'], 200);
    }

    // public function indexPeminjamanAlat(): JsonResponse
    // {
    //     // $data = PeminjamanBarang::all();
    //     $data = PeminjamanBarang::with(['prodi', 'angkatan', 'matkul', 'dosen', 'barang'])->get();

    //     if ($data->isEmpty()) {
    //         return response()->json(['message' => 'No data found'], 404);
    //     }

    //     return response()->json($data, 200);
    // }

    public function indexPeminjamanAlat(Request $request): JsonResponse
    {
        $query = PeminjamanBarang::with(['prodi', 'angkatan', 'matkul', 'dosen', 'barang']);

        if ($request->has('nama_peminjam')) {
            $query->where('nama_peminjam', $request->nama_peminjam);
        }

        if ($request->has('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_peminjam', 'LIKE', '%' . $request->cari . '%')
                    ->orWhereHas('barang', function ($q2) use ($request) {
                        $q2->where('nama_barang', 'LIKE', '%' . $request->cari . '%');
                    });
            });
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }


    public function storePeminjamanAlat(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_peminjam' => ['required'],
            'tgl_peminjaman' => ['required', 'date'],
            'nim' => ['required'],
            'no_hp' => ['required'],
            'barang_id' => ['required'],
            'matkul_id' => ['required'],
            'dosen_id' => ['required'],
            'prodi_id' => ['required'],
            'angkatan_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cek apakah barang masih tersedia
        $barang = Barang::find($request->barang_id);
        if (!$barang || $barang->stok <= 0) {
            return response()->json([
                'errors' => ['barang_id' => ['Stok barang tidak mencukupi atau tidak ditemukan']]
            ], 422);
        }

        // Simpan peminjaman
        $data = PeminjamanBarang::create(array_merge(
            $validator->validated(),
            ['status_peminjaman' => '0']
        ));

        // Kurangi stok
        $barang->decrement('stok');

        //  if (auth()->user()->type == '1') {
        //     return redirect()->route('peminjaman-barang.index')
        //         ->with('success', 'Peminjaman berhasil ditambahkan!');
        // } else {
        //     return redirect()->route('user.home')
        //         ->with('success', 'Silahkan Ambil barang di ruangan admin dan bawa KTM Anda');
        // }

        return response()->json([
            'message' => 'Peminjaman Alat berhasil ditambahkan',
        ], 201);
    }

    public function getPeminjamanAlat($id): JsonResponse
    {
        $data = PeminjamanBarang::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updatePeminjamanAlat(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_peminjam' => ['required'],
            'tgl_peminjaman' => ['required', 'date'],
            'nim' => ['required'],
            'no_hp' => ['required'],
            'barang_id' => ['required'],
            'matkul_id' => ['required'],
            'dosen_id' => ['required'],
            'prodi_id' => ['required'],
            'angkatan_id' => ['required'],
            'status_peminjaman' => ['required', 'in:0,1,2,3'], // sesuaikan nilai yang valid
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = PeminjamanBarang::find($id);
        if (!$data) {
            return response()->json(['errors' => ['id' => ['Data tidak ditemukan']]], 404);
        }

        $barang = Barang::find($request->barang_id);
        if (!$barang) {
            return response()->json(['errors' => ['barang_id' => ['Barang tidak ditemukan']]], 422);
        }

        // Jika status_peminjaman selesai (1), kembalikan stok
        if ($request->status_peminjaman == 1 && $data->status_peminjaman != 1) {
            $barang->update([
                'stok' => $barang->stok + 1,
                'status_barang' => 1
            ]);
        } elseif ($request->status_peminjaman != 1) {
            $barang->update(['status_barang' => 0]);
        }

        $data->update($validator->validated());

        return response()->json([
            'message' => 'Peminjaman berhasil diperbarui'
        ], 200);
    }

    public function destroyPeminjamanAlat($id): JsonResponse
    {
        $data = PeminjamanBarang::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Peminjaman Alat deleted successfully'], 200);
    }

    public function indexRuang()
    {
        $data = Ruang::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeRuang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruang' => 'required|min:5|max:100',
            'keterangan' => 'required|min:5|max:100',
            'status_ruang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Ruang::create($validator->validated());

        return response()->json(['message' => 'Ruang created successfully'], 201);
    }

    public function getRuang($id)
    {
        $data = Ruang::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateRuang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruang' => 'required|min:5|max:100',
            'keterangan' => 'required|min:5|max:100',
            'status_ruang' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ruang = Ruang::find($id);

        if (!$ruang) {
            return response()->json(['message' => 'Ruang not found'], 404);
        }

        $ruang->update($validator->validated());

        return response()->json(['message' => 'Ruang updated successfully'], 200);
    }

    public function destroyRuang($id)
    {
        $ruang = Ruang::find($id);

        if (!$ruang) {
            return response()->json(['message' => 'Ruang not found'], 404);
        }

        $ruang->delete();

        return response()->json(['message' => 'Ruang deleted successfully'], 200);
    }

    public function indexPeminjamanRuang()
    {
        $data = PeminjamanRuang::with(['ruang', 'jamx', 'jamy'])->get();
        // $data = PeminjamanRuang::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storePeminjamanRuang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_peminjam' => 'required',
            'tgl_peminjaman' => 'required|date',
            'ruang_id' => 'required',
            'mata_kuliah' => 'required',
            'dosen' => 'required',
            'jam_mulai_id' => 'required',
            'jam_selesai_id' => 'required',
            'prodi' => 'required',
            'angkatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Validasi jam
        $jamMulai = Jam::find($data['jam_mulai_id']);
        $jamSelesai = Jam::find($data['jam_selesai_id']);
        if (!$jamMulai || !$jamSelesai) {
            return response()->json(['errors' => ['jam' => ['Jam tidak valid']]], 422);
        }

        if (strtotime($jamMulai->jam) >= strtotime($jamSelesai->jam)) {
            return response()->json(['errors' => ['jam' => ['Jam mulai harus lebih awal dari jam selesai']]], 422);
        }

        // Validasi tanggal minimal hari ini
        if (Carbon::parse($data['tgl_peminjaman'])->isBefore(Carbon::today())) {
            return response()->json(['errors' => ['tgl_peminjaman' => ['Tanggal peminjaman minimal hari ini']]], 422);
        }

        // Validasi jam operasional (07:30 – 19:00)
        $jamMulaiTime = strtotime($jamMulai->jam);
        $jamSelesaiTime = strtotime($jamSelesai->jam);
        if ($jamMulaiTime < strtotime('07:30:00') || $jamSelesaiTime > strtotime('19:00:00')) {
            return response()->json(['errors' => ['jam' => ['Jam harus antara 07:30 sampai 19:00']]], 422);
        }

        // Validasi bentrok peminjaman
        $bentrokPeminjaman = PeminjamanRuang::where('tgl_peminjaman', $data['tgl_peminjaman'])
            ->where('ruang_id', $data['ruang_id'])
            ->where('status_peminjaman', 1)
            ->whereHas('Jamx', fn($q) => $q->where('jam', '<', $jamSelesai->jam))
            ->whereHas('Jamy', fn($q) => $q->where('jam', '>', $jamMulai->jam))
            ->exists();

        if ($bentrokPeminjaman) {
            return response()->json(['errors' => ['jadwal' => ['Jadwal bentrok dengan peminjaman lain']]], 422);
        }

        // Validasi bentrok dengan jadwal tetap
        $hari = strtolower(Carbon::parse($data['tgl_peminjaman'])->isoFormat('dddd'));
        $bentrokTetap = JadwalRuangan::where('hari', $hari)
            ->where('ruang_id', $data['ruang_id'])
            ->where('jam_mulai', '<', $jamSelesai->jam)
            ->where('jam_selesai', '>', $jamMulai->jam)
            ->exists();

        if ($bentrokTetap) {
            return response()->json(['errors' => ['jadwal' => ['Jadwal bentrok dengan jadwal tetap']]], 422);
        }

        PeminjamanRuang::create($data);
        return response()->json(['message' => 'Peminjaman Ruang created successfully'], 201);
    }


    // public function storePeminjamanRuang(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama_peminjam' => 'required',
    //         'tgl_peminjaman' => 'required|date',
    //         'ruang_id' => 'required',
    //         'matkul_id' => 'required',
    //         'dosen_id' => 'required',
    //         'jam_mulai_id' => 'required',
    //         'jam_selesai_id' => 'required',
    //         'prodi_id' => 'required',
    //         'angkatan_id' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     PeminjamanRuang::create($validator->validated());

    //     return response()->json(['message' => 'Peminjaman Ruang created successfully'], 201);
    // }

    public function getPeminjamanRuang($id)
    {
        $data = PeminjamanRuang::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updatePeminjamanRuang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_peminjam' => 'required',
            'tgl_peminjaman' => 'required|date',
            'ruang_id' => 'required',
            'mata_kuliah' => 'required',
            'dosen' => 'required',
            'jam_mulai_id' => 'required',
            'jam_selesai_id' => 'required',
            'prodi' => 'required',
            'angkatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $jamMulai = Jam::find($data['jam_mulai_id']);
        $jamSelesai = Jam::find($data['jam_selesai_id']);

        if (strtotime($jamMulai->jam) >= strtotime($jamSelesai->jam)) {
            return response()->json(['errors' => ['jam' => ['Jam mulai harus lebih awal dari jam selesai']]], 422);
        }

        if (Carbon::parse($data['tgl_peminjaman'])->isBefore(Carbon::today())) {
            return response()->json(['errors' => ['tgl_peminjaman' => ['Tanggal peminjaman minimal hari ini']]], 422);
        }

        if (
            strtotime($jamMulai->jam) < strtotime('07:30:00') ||
            strtotime($jamSelesai->jam) > strtotime('19:00:00')
        ) {
            return response()->json(['errors' => ['jam' => ['Jam harus antara 07:30 sampai 19:00']]], 422);
        }

        $bentrokPeminjaman = PeminjamanRuang::where('id', '!=', $id)
            ->where('tgl_peminjaman', $data['tgl_peminjaman'])
            ->where('ruang_id', $data['ruang_id'])
            ->where('status_peminjaman', 1)
            ->whereHas('Jamx', fn($q) => $q->where('jam', '<', $jamSelesai->jam))
            ->whereHas('Jamy', fn($q) => $q->where('jam', '>', $jamMulai->jam))
            ->exists();

        if ($bentrokPeminjaman) {
            return response()->json(['errors' => ['jadwal' => ['Jadwal bentrok dengan peminjaman lain']]], 422);
        }

        $hari = strtolower(Carbon::parse($data['tgl_peminjaman'])->isoFormat('dddd'));
        $bentrokTetap = JadwalRuangan::where('hari', $hari)
            ->where('ruang_id', $data['ruang_id'])
            ->where('jam_mulai', '<', $jamSelesai->jam)
            ->where('jam_selesai', '>', $jamMulai->jam)
            ->exists();

        if ($bentrokTetap) {
            return response()->json(['errors' => ['jadwal' => ['Jadwal bentrok dengan jadwal tetap']]], 422);
        }

        $model = PeminjamanRuang::find($id);
        if (!$model) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $model->update($data);
        return response()->json(['message' => 'Peminjaman Ruang updated successfully'], 200);
    }


    // public function updatePeminjamanRuang(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama_peminjam' => 'required',
    //         'tgl_peminjaman' => 'required|date',
    //         'ruang_id' => 'required',
    //         'matkul_id' => 'required',
    //         'dosen_id' => 'required',
    //         'jam_mulai_id' => 'required',
    //         'jam_selesai_id' => 'required',
    //         'prodi_id' => 'required',
    //         'angkatan_id' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = PeminjamanRuang::find($id);

    //     if (!$data) {
    //         return response()->json(['message' => 'Data not found'], 404);
    //     }

    //     $data->update($validator->validated());

    //     return response()->json(['message' => 'Peminjaman Ruang updated successfully'], 200);
    // }

    public function destroyPeminjamanRuang($id)
    {
        $data = PeminjamanRuang::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Peminjaman Ruang deleted successfully'], 200);
    }

    public function updateStatusPeminjamanRuang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status_peminjaman' => 'required|in:1,2'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = PeminjamanRuang::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        if ($request->status_peminjaman == 1) {
            $jamMulai = Jam::find($data->jam_mulai_id);
            $jamSelesai = Jam::find($data->jam_selesai_id);

            if ($jamMulai && $jamSelesai) {
                $bentrokPeminjaman = PeminjamanRuang::where('id', '!=', $id)
                    ->where('tgl_peminjaman', $data->tgl_peminjaman)
                    ->where('ruang_id', $data->ruang_id)
                    ->where('status_peminjaman', 1)
                    ->whereHas('Jamx', fn($q) => $q->where('jam', '<', $jamSelesai->jam))
                    ->whereHas('Jamy', fn($q) => $q->where('jam', '>', $jamMulai->jam))
                    ->exists();

                if ($bentrokPeminjaman) {
                    return response()->json(['errors' => ['jadwal' => ['Jadwal bentrok dengan peminjaman lain yang sudah disetujui']]], 422);
                }

                $hari = strtolower(Carbon::parse($data->tgl_peminjaman)->isoFormat('dddd'));
                $bentrokTetap = JadwalRuangan::where('hari', $hari)
                    ->where('ruang_id', $data->ruang_id)
                    ->where('jam_mulai', '<', $jamSelesai->jam)
                    ->where('jam_selesai', '>', $jamMulai->jam)
                    ->exists();

                if ($bentrokTetap) {
                    return response()->json(['errors' => ['jadwal' => ['Jadwal bentrok dengan jadwal kelas rutin']]], 422);
                }
            }
        }

        $data->update([
            'status_peminjaman' => $request->status_peminjaman
        ]);

        return response()->json(['message' => 'Status Peminjaman Ruang updated successfully'], 200);
    }

    public function indexJadwalRuang()
    {
        $data = JadwalRuangan::with(['ruang', 'Penanggungjawab'])->get();
        // $data = JadwalRuangan::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function viewIndexJadwalRuang(Request $request)
    {
        $filterHari = $request->query('hari');
        $filterRuang = $request->query('ruang');

        $jadwal = JadwalRuangan::with(['Ruang'])
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
            'GHA 206',
            'GHA 213',
            'GHA 411'
        ];

        $matrix = [];

        // Inisialisasi matrix
        foreach ($ruanganList as $ruang) {
            if ($filterRuang && $filterRuang !== $ruang) continue;
            foreach ($jamHeaders as $jam) {
                $matrix[$ruang][$jam] = '-';
            }
        }

        // Isi matrix
        foreach ($jadwal as $d) {
            $hari = strtolower($d->hari);
            if ($filterHari && strtolower($filterHari) !== $hari) continue;

            $startTime = substr($d->jam_mulai ?? '00:00:00', 0, 5);
            $endTime = substr($d->jam_selesai ?? '00:00:00', 0, 5);
            $ruangNama = $d->ruang->nama_ruang ?? null;

            if (!$ruangNama || !isset($matrix[$ruangNama])) continue;

            $prodiMap = [
                'Ilmu Komputer' => 'Ilkom',
                'Pendidikan Matematika' => 'PM',
                'Matematika' => 'Mat',
                'Statistika' => 'Stat',
            ];

            $prodiFull = $d->prodi ?? '-';
            $ruang = $d->ruang->nama_ruang ?? '-';
            $prodi = $prodiMap[$prodiFull] ?? $prodiFull;
            $angkatan = substr($d->angkatan ?? '', -2);
            $matkul = $d->mata_kuliah ?? '-';
            $dosenInisial = $d->dosen ?? '-';

            $label = "$prodi'$angkatan - $matkul ($dosenInisial)";

            $current = $startTime;
            while ($current < $endTime) {
                $matrix[$ruangNama][$current] = $label;
                $time = \Carbon\Carbon::createFromFormat('H:i', $current)->addMinutes(30);
                $current = $time->format('H:i');
            }
        }

        return response()->json([
            'jamHeaders' => $jamHeaders,
            'ruanganList' => $ruanganList,
            'matrix' => $matrix
        ]);
    }

    public function viewCalendar(Request $request)
    {
        // Validasi permintaan
        $validator = Validator::make($request->all(), [
            'ruang' => 'nullable|string|exists:ruang,nama_ruang'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filterRuang = $request->ruang;

        // Ambil jadwal tetap
        $jadwal = JadwalRuangan::with(['Ruang'])
            ->when($filterRuang, fn($q) => $q->whereHas('Ruang', fn($r) => $r->where('nama_ruang', $filterRuang)))
            ->get();

        // Ambil peminjaman ruangan
        $peminjaman = PeminjamanRuang::with(['Ruang', 'Jamx', 'Jamy'])
            ->where('status_peminjaman', 1)
            ->when($filterRuang, fn($q) => $q->whereHas('Ruang', fn($r) => $r->where('nama_ruang', $filterRuang)))
            ->get();

        // Mapping hari ke angka (untuk FullCalendar)
        $dayMap = [
            'senin' => 1,
            'selasa' => 2,
            'rabu' => 3,
            'kamis' => 4,
            'jumat' => 5,
            'sabtu' => 6,
            'minggu' => 0,
        ];

        $events = [];

        $startDate = now()->startOfMonth();
        $endDate = now()->addMonths(1)->endOfMonth();

        // Event dari Jadwal Tetap
        foreach ($jadwal as $j) {
            $hari = strtolower($j->hari);
            $dayOfWeek = $dayMap[$hari] ?? null;
            if ($dayOfWeek === null) continue;

            $currentDate = $startDate->copy();
            // Move to the first matching day of week
            while ($currentDate->dayOfWeek != ($dayOfWeek == 0 ? \Carbon\Carbon::SUNDAY : $dayOfWeek)) {
                $currentDate->addDay();
            }

            while ($currentDate <= $endDate) {
                $tanggal = $currentDate->toDateString();
                
                // Check konfirmasi
                $konfirmasi = \App\Models\JadwalKonfirmasi::where('jadwal_ruangan_id', $j->id)
                    ->where('tanggal', $tanggal)
                    ->first();

                $status = $konfirmasi->status ?? 'pending';

                if ($status !== 'tidak_dilaksanakan') {
                    $color = '#3788d8'; // Biru (Pending / Default)
                    if ($status === 'dilaksanakan') {
                        $color = '#dc3545'; // Merah
                    }

                    $events[] = [
                        'title' => $j->mata_kuliah ?? 'Jadwal Tetap',
                        'start' => $tanggal . 'T' . substr($j->jam_mulai, 0, 5),
                        'end' => $tanggal . 'T' . substr($j->jam_selesai, 0, 5),
                        'color' => $color,
                    ];
                }

                $currentDate->addWeek();
            }
        }

        // Event dari Peminjaman Ruangan
        foreach ($peminjaman as $p) {
            $events[] = [
                'title' => 'Matkul Pengganti: ' . ($p->mata_kuliah ?? 'Kegiatan'),
                'start' => $p->tgl_peminjaman . 'T' . substr($p->jamx->jam, 0, 5),
                'end' => $p->tgl_peminjaman . 'T' . substr($p->jamy->jam, 0, 5),
                'color' => '#dc3545',
            ];
        }

        return view('user.kalender.kalender', [
            'events' => $events,
            'ruanganList' => Ruang::all(),
            'jam_mulai' => Jam::all(),
            'jam_selesai' => Jam::all(),
            'ruang' => Ruang::all(),
        ]);
    }


    public function storeJadwalRuang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id' => 'required|max:100',
            'mata_kuliah' => 'required',
            'dosen' => 'required',
            'hari' => 'required',
            'jam_mulai_ke' => 'required|integer|min:1|max:16',
            'jam_selesai_ke' => 'required|integer|min:1|max:16',
            'prodi' => 'required',
            'angkatan' => 'required',
            'kelas' => 'nullable',
            'status_ruang' => 'required',
            'user_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        $jamMulaiKe = $data['jam_mulai_ke'];
        $jamSelesaiKe = $data['jam_selesai_ke'];

        if ($jamMulaiKe >= $jamSelesaiKe) {
            return response()->json(['message' => 'Jam mulai harus lebih awal dari jam selesai.'], 422);
        }

        $data['jam_mulai'] = sprintf('%02d:00:00', 7 + $jamMulaiKe);
        $data['jam_selesai'] = sprintf('%02d:50:00', 7 + $jamSelesaiKe);

        // Validasi bentrok jadwal
        $cekBentrok = JadwalRuangan::where('hari', $data['hari'])
            ->where('ruang_id', $data['ruang_id'])
            ->where('jam_mulai', '<', $data['jam_selesai'])
            ->where('jam_selesai', '>', $data['jam_mulai'])
            ->exists();

        if ($cekBentrok) {
            return response()->json(['message' => 'Ruangan sudah digunakan di jam tersebut.'], 422);
        }

        JadwalRuangan::create($data);

        return response()->json(['message' => 'Jadwal Ruangan berhasil ditambahkan.'], 201);
    }


    public function getJadwalRuang($id)
    {
        $data = JadwalRuangan::with('Penanggungjawab')->find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateJadwalRuang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id' => 'required',
            'mata_kuliah' => 'required',
            'dosen' => 'required',
            'hari' => 'required',
            'jam_mulai_ke' => 'required|integer|min:1|max:16',
            'jam_selesai_ke' => 'required|integer|min:1|max:16',
            'prodi' => 'required',
            'angkatan' => 'required',
            'kelas' => 'nullable',
            'status_ruang' => 'required',
            'user_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $jamMulaiKe = $validatedData['jam_mulai_ke'];
        $jamSelesaiKe = $validatedData['jam_selesai_ke'];

        if ($jamMulaiKe >= $jamSelesaiKe) {
            return response()->json(['message' => 'Jam mulai harus lebih awal dari jam selesai.'], 422);
        }

        $validatedData['jam_mulai'] = sprintf('%02d:00:00', 7 + $jamMulaiKe);
        $validatedData['jam_selesai'] = sprintf('%02d:50:00', 7 + $jamSelesaiKe);

        $cekBentrok = JadwalRuangan::where('hari', $validatedData['hari'])
            ->where('ruang_id', $validatedData['ruang_id'])
            ->where('id', '!=', $id)
            ->where('jam_mulai', '<', $validatedData['jam_selesai'])
            ->where('jam_selesai', '>', $validatedData['jam_mulai'])
            ->exists();

        if ($cekBentrok) {
            return response()->json(['message' => 'Ruangan sudah digunakan di jam tersebut'], 422);
        }

        $data = JadwalRuangan::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->update($validatedData);

        // Update status ruang jika diperlukan
        $ruang = Ruang::find($request->ruang_id);
        if ($ruang) {
            $ruang->status_ruang = $request->status_ruang;
            $ruang->save();
        }

        return response()->json(['message' => 'Jadwal Ruang updated successfully'], 200);
    }


    public function destroyJadwalRuang($id)
    {
        $data = JadwalRuangan::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Jadwal Ruang deleted successfully'], 200);
    }

    public function destroyAllJadwalRuang()
    {
        $jumlah = JadwalRuangan::count();

        if ($jumlah === 0) {
            return response()->json(['message' => 'Tidak ada data yang bisa dihapus'], 404);
        }

        JadwalRuangan::query()->delete();

        return response()->json(['message' => 'Semua Jadwal Ruang berhasil dihapus'], 200);
    }

    public function indexMataKuliah()
    {
        $data = MataKuliah::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeMataKuliah(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mata_kuliah' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        MataKuliah::create($validator->validated());

        return response()->json(['message' => 'Mata Kuliah created successfully'], 201);
    }

    public function getMataKuliah($id)
    {
        $data = MataKuliah::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateMataKuliah(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mata_kuliah' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = MataKuliah::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->update($validator->validated());

        return response()->json(['message' => 'Mata Kuliah updated successfully'], 200);
    }

    public function destroyMataKuliah($id)
    {
        $data = MataKuliah::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Mata Kuliah deleted successfully'], 200);
    }

    public function indexDosen()
    {
        $data = NamaDosen::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No dosen found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeDosen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required|max:100|unique:nama_dosens',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        NamaDosen::create($validator->validated());

        return response()->json(['message' => 'Dosen created successfully'], 201);
    }

    public function getDosen($id)
    {
        $data = NamaDosen::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateDosen(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required|max:100|unique:nama_dosens',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = NamaDosen::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->update($validator->validated());

        return response()->json(['message' => 'Dosen updated successfully'], 200);
    }

    public function ubahStatus(Request $request)
{
    $request->validate([
        'dosen_id' => 'required',
    ]);

    $dosen = NamaDosen::findOrFail($request->dosen_id);

    $dosen->kehadiran_dosen = $dosen->kehadiran_dosen == 1 ? 0 : 1;

    $dosen->save();

    return response()->json([
        'message' => 'Status kehadiran dosen berhasil diubah',
        'status' => $dosen->kehadiran_dosen
    ], 200);
}


    public function destroyDosen($id)
    {
        $dosen = NamaDosen::find($id);

        if (!$dosen) {
            return response()->json(['message' => 'Dosen not found'], 404);
        }

        $dosen->delete();

        return response()->json(['message' => 'Dosen deleted successfully'], 200);
    }

    public function indexJam()
    {
        $data = Jam::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeJam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jam' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Jam::create($validator->validated());

        return response()->json(['message' => 'Jam created successfully'], 201);
    }

    public function getJam($id)
    {
        $data = Jam::find($id);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateJam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jam' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = Jam::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $data->update($validator->validated());

        return response()->json(['message' => 'Jam updated successfully'], 200);
    }

    public function destroyJam($id)
    {
        $jam = Jam::find($id);

        if (!$jam) {
            return response()->json(['message' => 'Jam not found'], 404);
        }

        $jam->delete();

        return response()->json(['message' => 'Jam deleted successfully'], 200);
    }

    public function indexProdi()
    {
        $data = Prodi::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeProdi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_prodi' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $prodi = Prodi::create($validator->validated());

        return response()->json(['message' => 'Prodi created successfully'], 201);
    }

    public function getProdi($id)
    {
        $data = Prodi::find($id);

        if (!$data) {
            return response()->json(['message' => 'Prodi not found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateProdi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_prodi' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $prodi = Prodi::find($id);

        if (!$prodi) {
            return response()->json(['message' => 'Prodi not found'], 404);
        }

        $prodi->update($validator->validated());

        return response()->json(['message' => 'Prodi updated successfully'], 200);
    }

    public function destroyProdi($id)
    {
        $prodi = Prodi::find($id);

        if (!$prodi) {
            return response()->json(['message' => 'Prodi not found'], 404);
        }

        $prodi->delete();

        return response()->json(['message' => 'Prodi deleted successfully'], 200);
    }

    public function indexAngkatan()
    {
        $data = Angkatan::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeAngkatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'angkatan' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $angkatan = Angkatan::create($validator->validated());

        return response()->json([
            'message' => 'Angkatan created successfully'
        ], 201);
    }

    public function getAngkatan($id)
    {
        $data = Angkatan::find($id);

        if (!$data) {
            return response()->json(['message' => 'Angkatan not found'], 404);
        }

        return response()->json($data, 200);
    }

    public function updateAngkatan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'angkatan' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $angkatan = Angkatan::find($id);

        if (!$angkatan) {
            return response()->json(['message' => 'Angkatan not found'], 404);
        }

        $angkatan->update($validator->validated());

        return response()->json([
            'message' => 'Angkatan updated successfully'
        ], 200);
    }

    public function destroyAngkatan($id)
    {
        $angkatan = Angkatan::find($id);

        if (!$angkatan) {
            return response()->json(['message' => 'Angkatan not found'], 404);
        }

        $angkatan->delete();

        return response()->json(['message' => 'Angkatan deleted successfully'], 200);
    }

    public function indexMahasiswa()
    {
        $data = User::with(['prodi', 'angkatan'])->where('type', 'mahasiswa')->get();
        // $data = User::with(['prodi', 'angkatan'])->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json($data);
    }

    public function storeMahasiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100'],
            'username' => ['required', 'max:100', 'unique:users,username'],
            'prodi_id' => ['nullable'],
            'type' => ['required'],
            'angkatan_id' => ['nullable'],
            'password' => ['required', 'min:6'],
            'no_telfon' => ['nullable', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return response()->json(['message' => 'Mahasiswa created successfully'], 201);
    }

    public function getMahasiswa($id)
    {
        $data = User::with(['prodi', 'angkatan'])->where('id', $id)->where('type', 'mahasiswa')->first();
        if ($data == null) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json($data);
    }

    public function updateMahasiswa(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'username' => 'required|max:100|unique:users,username,' . $id,
            'prodi_id' => 'required|exists:prodis,id',
            'angkatan_id' => 'required|exists:angkatans,id',
            'no_telfon' => 'nullable|max:50',
            'password' => 'nullable|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mahasiswa = User::where('id', $id)->where('type', 'mahasiswa')->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        $data = $validator->validated();

        // Jika password diisi, hash
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $mahasiswa->update($data);

        return response()->json([
            'message' => 'Mahasiswa updated successfully'
        ], 200);
    }

    public function destroyMahasiswa($id)
    {
        $data = User::find($id);
        $data->delete();

        return response()->json(['message' => 'Mahasiswa deleted successfully'], 201);
    }

    // public function updateMahasiswa(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required',
    //         'name' => 'required',
    //         'username' => 'required',
    //         'prodi_id' => 'required',
    //         'angkatan_id' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()
    //             ->json(['errors' => $validator->errors()], 422);
    //     }

    //     // $data = Barang::find($id);
    //     User::where('id', $id)
    //         ->update([
    //             'nama_barang' => $request->nama_barang,
    //             'deskripsi_barang' => $request->deskripsi_barang,
    //             'status_barang' => $request->status_barang,
    //             'stok' => $request->stok
    //         ]);

    //     return response()->json(['message' => 'Mahasiswa updated successfully'], 201);
    // }

    // public function indexMahasiswa()
    // {
    //     $data = User::where('type', 'mahasiswa')->get();

    //     if ($data->isEmpty()) {
    //         return response()->json(['message' => 'No data found'], 404);
    //     }

    //     return response()->json(['data' => $data], 200);
    // }

    // public function storeMahasiswa(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|max:100',
    //         'username' => 'required|max:100|unique:users,username',
    //         'prodi_id' => 'required|exists:prodis,id',
    //         'angkatan_id' => 'required|exists:angkatans,id',
    //         'type' => 'required',
    //         'password' => 'required|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $validated = $validator->validated();
    //     $validated['password'] = Hash::make($validated['password']);

    //     $mahasiswa = User::create($validated);

    //     return response()->json([
    //         'message' => 'Mahasiswa created successfully',
    //         'data' => $mahasiswa
    //     ], 201);
    // }

    // public function getMahasiswa($id)
    // {
    //     $data = User::where('id', $id)->where('type', 'mahasiswa')->first();

    //     if (!$data) {
    //         return response()->json(['message' => 'Mahasiswa not found'], 404);
    //     }

    //     return response()->json(['data' => $data], 200);
    // }


    // public function destroyMahasiswa($id)
    // {
    //     $data = User::where('id', $id)->where('type', 'mahasiswa')->first();

    //     if (!$data) {
    //         return response()->json(['message' => 'Mahasiswa not found'], 404);
    //     }

    //     $data->delete();

    //     return response()->json(['message' => 'Mahasiswa deleted successfully'], 200);
    // }

    public function indexFeedback()
    {
        $data = Feedback::all();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($data, 200);
    }

    public function storeFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_feedback' => 'required|date',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'saran' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $feedback = Feedback::create($validated);

        return response()->json([
            'message' => 'Feedback created successfully',
            'data' => $feedback
        ], 201);
    }

    public function getFeedback($id)
    {
        $data = Feedback::find($id);

        if (!$data) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        return response()->json(['data' => $data], 200);
    }

    public function destroyFeedback($id)
    {
        $data = Feedback::find($id);
        if ($data == null) {
            return response()->json(['message' => 'No data found'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Feedback deleted successfully'], 200);
    }

    public function savePushSubscription(Request $request)
    {
        $request->validate([
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
            'user_id' => 'required'
        ]);

        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->updatePushSubscription(
            $request->endpoint,
            $request->keys['p256dh'],
            $request->keys['auth']
        );

        return response()->json(['success' => true]);
    }

    public function submitKonfirmasi(Request $request)
    {
        $request->validate([
            'jadwal_ruangan_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:dilaksanakan,tidak_dilaksanakan'
        ]);

        $konfirmasi = \App\Models\JadwalKonfirmasi::updateOrCreate(
            [
                'jadwal_ruangan_id' => $request->jadwal_ruangan_id,
                'tanggal' => $request->tanggal,
            ],
            [
                'status' => $request->status,
                'waktu_konfirmasi' => now()
            ]
        );

        return response()->json(['success' => true, 'data' => $konfirmasi]);
    }

    public function listKonfirmasi($user_id)
    {
        $konfirmasis = \App\Models\JadwalKonfirmasi::with(['jadwalRuangan.ruang'])
            ->whereHas('jadwalRuangan', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($konfirmasis);
    }

    public function listSemuaKonfirmasi()
    {
        $konfirmasis = \App\Models\JadwalKonfirmasi::with(['jadwalRuangan.ruang', 'jadwalRuangan.Penanggungjawab'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($konfirmasis);
    }
}
