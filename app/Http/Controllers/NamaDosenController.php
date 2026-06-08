<?php

namespace App\Http\Controllers;

use App\Models\NamaDosen;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreNamaDosenRequest;
use App\Http\Requests\UpdateNamaDosenRequest;

class NamaDosenController extends Controller
{
    public function index()
    {
        $data = NamaDosen::all();
        $title = 'Delete Dosen!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/dosen/index', [
            'title' => 'Data Dosen',
            'data' => $data
        ]);
    }

    public function viewdosen()
    {
        $data = NamaDosen::all();
        return view('user/dosen/dosen', [
            'data' => $data
        ]);
    }


    public function create()
    {
        return view('admin/dosen/create', [
            'title' => 'Tambah Data Dosen'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dosen' => ['required', 'max:100'],

        ]);

        if ($validator->fails()) {
            return redirect('dosen/tambah')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        NamaDosen::create($validated);

        Alert::success('Berhasil', 'Dosen Berhasil Ditambahkan');

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = NamaDosen::where('id', $id)->first();
        return view('admin/dosen/edit', [
            'title' => 'Edit Data Dosen',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        dd("ubah status");

        $request->validate([
            'id' => 'required',
            'nama_dosen' => 'required|max:100',

        ]);

        // $data = Prodi::find($id);
        NamaDosen::where('id', $id)
            ->update([
                'nama_dosen' => $request->nama_dosen,

            ]);

        Alert::success('Berhasil', 'Dosen Berhasil Diubah');

        return redirect()->route('dosen.index')
            ->with('success', 'Dosen berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = NamaDosen::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Dosen Berhasil Dihapus');

        return redirect()->route('dosen.index')
            ->with('success', 'Dosen berhasil dihapus!');
    }

    public function ubahstatus(Request $request)
    {
        // dd("ubah status");
        // logger("pildungggg");
        $data = NamaDosen::where('id', $request->dosen_id)->first();
        if ($data->kehadiran_dosen == "1") {
            // logger("hadir nih");
            // dd("mandi");
            NamaDosen::where('id', $request->dosen_id)
                ->update([
                    'kehadiran_dosen' => "0",
                ]);
        } else {
            // logger("mana jir");
            NamaDosen::where('id', $request->dosen_id)
                ->update([
                    'kehadiran_dosen' => "1",
                ]);
        }


        Alert::success('Berhasil', 'Kehadiran Dosen Berhasil Diubah');

        return redirect()->route('dosen.index')
            ->with('success', 'Dosen berhasil diubah!');
    }
}
