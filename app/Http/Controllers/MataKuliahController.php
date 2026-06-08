<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;

class MataKuliahController extends Controller
{
    public function index()
    {
        $data = MataKuliah::all();
        $title = 'Delete Mata Kuliah!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/mata-kuliah/index', [
            'title' => 'Data Mata Kuliah',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin/mata-kuliah/create', [
            'title' => 'Tambah Data Mata Kuliah'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mata_kuliah' => ['required', 'max:100'],

        ]);

        if ($validator->fails()) {
            return redirect('matkul/tambah')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        MataKuliah::create($validated);

        Alert::success('Berhasil', 'Mata Kuliah Berhasil Ditambahkan');

        return redirect()->route('matkul.index')->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = MataKuliah::where('id', $id)->first();
        return view('admin/mata-kuliah/edit', [
            'title' => 'Edit Data Mata Kuliah',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'mata_kuliah' => 'required|max:100',

        ]);

        // $data = Prodi::find($id);
        MataKuliah::where('id', $id)
            ->update([
                'mata_kuliah' => $request->mata_kuliah,

            ]);

        Alert::success('Berhasil', 'Mata Kuliah Berhasil Diubah');

        return redirect()->route('matkul.index')
            ->with('success', 'Mata Kuliah berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = MataKuliah::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Mata Kuliah Berhasil Dihapus');

        return redirect()->route('matkul.index')
            ->with('success', 'Mata Kuliah berhasil dihapus!');
    }
}
