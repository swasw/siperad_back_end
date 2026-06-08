<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProdiRequest;
use App\Http\Requests\UpdateProdiRequest;
use App\Models\PeminjamanBarang;
use App\Models\PeminjamanRuang;
use App\Models\User;

class ProdiController extends Controller
{
    public function index()
    {
        $data = Prodi::all();
        $title = 'Delete Prodi!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/prodi/index', [
            'title' => 'Data Prodi',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin/prodi/create', [
            'title' => 'Tambah Data Prodi'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_prodi' => ['required', 'max:100'],

        ]);

        if ($validator->fails()) {
            return redirect('prodi/tambah')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        Prodi::create($validated);

        Alert::success('Berhasil', 'Ruangan Berhasil Ditambahkan');

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Prodi::where('id', $id)->first();
        return view('admin/prodi/edit', [
            'title' => 'Edit Data Prodi',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'nama_prodi' => 'required|max:100',

        ]);

        // $data = Prodi::find($id);
        Prodi::where('id', $id)
            ->update([
                'nama_prodi' => $request->nama_prodi,

            ]);

        Alert::success('Berhasil', 'Ruangan Berhasil Diubah');

        return redirect()->route('prodi.index')
            ->with('success', 'Prodi berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = Prodi::find($id);
        $data->delete();

        PeminjamanBarang::where('prodi_id', $id)->delete();
        PeminjamanRuang::where('prodi_id', $id)->delete();
        User::where('prodi_id', $id)->delete();

        Alert::success('Berhasil', 'Ruangan Berhasil Dihapus');

        return redirect()->route('prodi.index')
            ->with('success', 'Prodi berhasil dihapus!');
    }

    // public function destroyAll()
    // {
    //     Prodi::query()->delete();

    //     Alert::success('Berhasil', 'Semua Prodi Berhasil Dihapus');

    //     return redirect()->route('prodi.index')
    //         ->with('success', 'Semua Prodi berhasil dihapus!');
    // }
}
