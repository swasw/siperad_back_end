<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJamRequest;
use App\Http\Requests\UpdateJamRequest;

class JamController extends Controller
{
    public function index()
    {
        $data = Jam::all();
        $title = 'Delete Jam!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/jam/index', [
            'title' => 'Data Jam',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin/jam/create', [
            'title' => 'Tambah Data Jam'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jam' => ['required'],

        ]);

        if ($validator->fails()) {
            return redirect('jam/tambah')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        Jam::create($validated);

        Alert::success('Berhasil', 'Jam Berhasil Ditambahkan');

        return redirect()->route('jam.index')->with('success', 'Jam berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Jam::where('id', $id)->first();
        return view('admin/jam/edit', [
            'title' => 'Edit Data Jam',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'jam' => 'required',

        ]);

        // $data = Prodi::find($id);
        Jam::where('id', $id)
            ->update([
                'jam' => $request->jam,

            ]);

        Alert::success('Berhasil', 'Jam Berhasil Diubah');

        return redirect()->route('jam.index')
            ->with('success', 'Jam berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = Jam::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Jam Berhasil Dihapus');

        return redirect()->route('jam.index')
            ->with('success', 'Jam berhasil dihapus!');
    }
}
