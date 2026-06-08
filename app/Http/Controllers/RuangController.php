<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;
use RealRashid\SweetAlert\Facades\Alert;

class RuangController extends Controller
{
    public function index() {
        $data = Ruang::all();
        $title = 'Delete Ruangan!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/ruang/index', [
            'title' => 'Data Ruang',
            'data' => $data
        ]);
    }

    public function create() {
        return view('admin/ruang/create', [
            'title' => 'Tambah Data Ruang'
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_ruang' => 'required|min:5|max:100',
            'keterangan' => 'required|min:5|max:100',
            'status_ruang'
        ]);

        Ruang::create($request->all());
        Alert::success('Berhasil', 'Ruangan Berhasil Ditambahkan');

        return redirect()->route('ruang.index')
                        ->with('success', 'Ruang berhasil ditambahkan!');
    }

    public function edit($id) {
        $data = Ruang::where('id', $id)->first();
        return view('admin/ruang/edit', [
            'title' => 'Edit Data Ruang',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_ruang' => 'required|min:5|max:100',
            'keterangan' => 'required|min:5|max:100',
            'status_ruang' => 'required'
        ]);
        
        $data = Ruang::find($id);
        $data->update($request->all());
        Alert::success('Berhasil', 'Ruangan Berhasil Diubah');

        return redirect()->route('ruang.index')
                        ->with('success', 'Ruang berhasil diubah!');
    }

    public function destroy($id) {
        $data = Ruang::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Ruangan Berhasil Dihapus');

        return redirect()->route('ruang.index')
                        ->with('success', 'Ruang berhasil dihapus!');
    }
}
