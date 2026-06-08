<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JadwalRuangan;
use App\Models\Ruang;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function apigetAlat()
    {
        $data = Barang::all();

        if (!$data->count() < 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ada!'
            ], 404);
        } else {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
    }

    public function postAlat(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|max:100',
            'deskripsi_barang' => 'required|max:100',
            'status_barang' => 'required',
            'stok' => 'required|numeric|min:0',
        ]);

        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang sudah ada!'
            ], 404);
        }

        Barang::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan!'
        ]);
    }

    public function updateAlat(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|max:100',
            'deskripsi_barang' => 'required|max:100',
            'status_barang' => 'required',
            'stok' => 'required|numeric|min:0',
        ]);

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan!'
            ], 404);
        }

        $barang->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil diperbarui!'
        ]);
    }

    public function deleteAlat($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan!'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil dihapus!'
        ]);
    }

    public function apigetRuang()
    {
        $data = Ruang::all();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function postRuang(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|max:100',
            'deskripsi_barang' => 'required|max:100',
            'status_barang' => 'required',
            'stok' => 'required|numeric|min:0',
        ]);

        Ruang::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan!'
        ]);
    }

    public function apigetJadwalRuangan()
    {
        $data = JadwalRuangan::all();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function postJadwalRuangan(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|max:100',
            'deskripsi_barang' => 'required|max:100',
            'status_barang' => 'required',
            'stok' => 'required|numeric|min:0',
        ]);

        JadwalRuangan::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan!'
        ]);
    }
}
