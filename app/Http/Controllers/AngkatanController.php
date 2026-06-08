<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreAngkatanRequest;
use App\Http\Requests\UpdateAngkatanRequest;
use App\Models\Angkatan;

class AngkatanController extends Controller
{
    public function index()
    {
        $data = Angkatan::all();
        $title = 'Delete Angkatan!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/angkatan/index', [
            'title' => 'Data Angkatan',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin/angkatan/create', [
            'title' => 'Tambah Data Angkatan'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'angkatan' => ['required', 'max:100'],

        ]);

        if ($validator->fails()) {
            return redirect('angkatan/tambah')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        Angkatan::create($validated);

        Alert::success('Berhasil', 'Angkatan Berhasil Ditambahkan');

        return redirect()->route('angkatan.index')->with('success', 'Angkatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Angkatan::where('id', $id)->first();
        return view('admin/angkatan/edit', [
            'title' => 'Edit Data Angkatan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'angkatan' => 'required|max:100',

        ]);

        // $data = Prodi::find($id);
        Angkatan::where('id', $id)
            ->update([
                'angkatan' => $request->angkatan,

            ]);

        Alert::success('Berhasil', 'Angkatan Berhasil Diubah');

        return redirect()->route('angkatan.index')
            ->with('success', 'Angkatan berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = Angkatan::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Angkatan Berhasil Dihapus');

        return redirect()->route('angkatan.index')
            ->with('success', 'Angkatan berhasil dihapus!');
    }
}
