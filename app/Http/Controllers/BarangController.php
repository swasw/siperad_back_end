<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::all();
        $title = 'Delete Alat!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        if (auth()->user()->type == '1') {
            return view('admin/barang/index', [
                'title' => 'Data Alat',
                'data' => $data
            ]);
        } else {
            // dd($ruanganList);
            return view('user/alat/view', [
                'data' => $data
            ]);
        }
    }


    public function create()
    {
        return view('admin/barang/create', [
            'title' => 'Tambah Data Alat'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => ['required', 'max:100'],
            'deskripsi_barang' => ['required', 'max:100'],
            'status_barang' => ['required'],
            'stok' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return redirect('barang/tambah')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        Barang::create($validated);

        Alert::success('Berhasil', 'Barang Berhasil Ditambahkan');

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Barang::where('id', $id)->first();
        return view('admin/barang/edit', [
            'title' => 'Edit Data Alat',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'nama_barang' => 'required|max:100',
            'deskripsi_barang',
            'status_barang' => 'required',
            'stok' => 'required'
        ]);

        // $data = Barang::find($id);
        Barang::where('id', $id)
            ->update([
                'nama_barang' => $request->nama_barang,
                'deskripsi_barang' => $request->deskripsi_barang,
                'status_barang' => $request->status_barang,
                'stok' => $request->stok
            ]);

        Alert::success('Berhasil', 'Barang Berhasil Diubah');

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = Barang::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Barang Berhasil Dihapus');

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
