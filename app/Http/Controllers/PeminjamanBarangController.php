<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;
use App\Http\Requests\StorePeminjamanBarangRequest;
use App\Http\Requests\UpdatePeminjamanBarangRequest;
use App\Models\Angkatan;
use App\Models\Barang;
use App\Models\MataKuliah;
use App\Models\NamaDosen;
use App\Models\Prodi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanBarangController extends Controller
{
    // public function index(Request $request)
    // {
    //     $data = PeminjamanBarang::with(['Prodi', 'Angkatan', 'Barang', 'Matkul', 'Dosen'])->get();
    //     $title = 'Delete Peminjaman Alat!';
    //     $text = "Are you sure you want to delete?";
    //     confirmDelete($title, $text);
    //     if (auth()->user()->type == '1') {
    //         return view('admin/peminjaman-barang/index', [
    //             'title' => 'Data Peminjaman Alat',
    //             'data' => $data
    //         ]);
    //     } else {
    //         if ($request->has('cari')) {
    //             $data = PeminjamanBarang::where('nama_peminjam', 'LIKE', '%' . $request->cari . '%')->get();
    //         } else {
    //             $data = PeminjamanBarang::all();
    //         }
    //         // dd($prodi);
    //         return view('user/data/peminjamanalat', [
    //             'title' => 'History Peminjaman Alat',
    //             'data' => $data
    //         ]);
    //     }
    // }

    public function index(Request $request)
    {
        $title = 'Delete Peminjaman Alat!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        if (auth()->user()->type == '1') {
            // Admin: tampilkan semua data
            $data = PeminjamanBarang::with(['Prodi', 'Angkatan', 'Barang', 'Matkul', 'Dosen'])->get();

            return view('admin/peminjaman-barang/index', [
                'title' => 'Data Peminjaman Alat',
                'data' => $data
            ]);
        } else {
            $query = PeminjamanBarang::with(['Prodi', 'Angkatan', 'Barang', 'Matkul', 'Dosen'])
                ->where('nama_peminjam', auth()->user()->name);

            if ($request->has('cari')) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_peminjam', 'LIKE', '%' . $request->cari . '%')
                        ->orWhere('nama_peminjam', 'LIKE', '%' . $request->cari . '%');
                });
            }

            $data = $query->get();

            return view('user/data/peminjamanalat', [
                'title' => 'History Peminjaman Alat',
                'data' => $data
            ]);
        }
    }

    public function create(Request $request)
    {
        if (auth()->user()->type == '1') {
            $barang = Barang::where('stok', '>', 0)->get();
        } else {
            $barang = Barang::where('stok', '>', 0)->find($request->alat_id);;
        }
        $prodi = Prodi::all();
        $matkul = MataKuliah::all();
        $dosen =  NamaDosen::all();
        $angkatan = Angkatan::all();
        if (auth()->user()->type == '1') {
            return view('admin/peminjaman-barang/create', [
                'title' => 'Tambah Peminjaman Alat',
                'barang' => $barang,
                'prodi' => $prodi,
                'matkul' => $matkul,
                'dosen' => $dosen,
                'angkatan' => $angkatan,
            ]);
        } else {
            // dd($prodi);
            return view('user/form/peminjamanalat', [
                // 'title' => 'Data Peminjaman Alat',
                'barang' => $barang,
                'prodi' => $prodi,
                'matkul' => $matkul,
                'dosen' => $dosen,
                'angkatan' => $angkatan,
            ]);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_peminjam' => ['required'],
            'tgl_peminjaman' => ['required'],
            'nim' => ['required'],
            'no_hp' => ['required'],
            'barang_id' => ['required', 'max:100'],
            'matkul_id' => ['required'],
            'dosen_id' => ['required'],
            'prodi_id' => ['required'],
            'angkatan_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated['status_peminjaman'] = "0";

        $cek = PeminjamanBarang::where('nama_peminjam', $request->nama_peminjam)
            ->whereIn('status_peminjaman', ['0', '2', '3'])
            ->first();
        $cekStok = Barang::where('id', $request->barang_id)
            ->first();

        PeminjamanBarang::create($request->all());
        if (auth()->user()->type == '1') {
            Alert::success('Berhasil', 'Peminjaman Alat Berhasil Ditambahkan');
        } else {
            Alert::success('Berhasil', 'Silahkan Ambil barang di ruangan admin dan bawa KTM Anda');
        }


        Barang::where('id', $request->barang_id)
            ->update([
                'stok' => $cekStok->stok - 1
            ]);


        if (auth()->user()->type == '1') {
            return redirect()->route('peminjaman-barang.index')
                ->with('success', 'Peminjaman berhasil ditambahkan!');
        } else {
            return redirect()->route('user.home')
                ->with('success', 'Silahkan Ambil barang di ruangan admin dan bawa KTM Anda');
        }
    }

    public function edit($id)
    {
        $barang = Barang::all();
        $prodi = Prodi::all();
        $matkul = MataKuliah::all();
        $dosen =  NamaDosen::all();
        $angkatan = Angkatan::all();
        $data = PeminjamanBarang::findOrFail($id);
        return view('admin/peminjaman-barang/edit', [
            'title' => 'Ubah Peminjaman Alat',
            'barang' => $barang,
            'prodi' => $prodi,
            'matkul' => $matkul,
            'dosen' => $dosen,
            'angkatan' => $angkatan,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required',
            'nama_peminjam' => 'required',
            'tgl_peminjaman' => 'required',
            'nim' => 'required',
            'no_hp' => 'required',
            'barang_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'prodi_id' => 'required',
            'angkatan_id' => 'required',
        ]);

        $data = PeminjamanBarang::find($id);

        if ($request->status_peminjaman == 1) {
            $temp = Barang::where('id', $request->barang_id)->first();
            // dd($temp);
            Barang::where('id', $request->barang_id)->update([
                'status_barang' => 1,
                'stok' => $temp->stok + 1
            ]);
        } else {
            $temp = Barang::where('id', $request->barang_id)->first();
            Barang::where('id', $request->barang_id)->update([
                'status_barang' => 0
            ]);
        }
        $data->update($request->all());

        Alert::success('Berhasil', 'Peminjaman Alat Berhasil Diubah');

        return redirect()->route('peminjaman-barang.index')
            ->with('success', 'Peminjaman berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = PeminjamanBarang::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Peminjaman Berhasil Dihapus');

        return redirect()->route('peminjaman-barang.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }
}
