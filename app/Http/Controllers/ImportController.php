<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angkatan;
use App\Models\Barang;
use Illuminate\Support\Facades\Response;

class ImportController extends Controller
{
    /**
     * Tampilkan halaman Input Multiple Data.
     */
    public function index()
    {
        return view('admin.import.index');
    }

    /**
     * Download template Angkatan (CSV Format yang bisa dibuka Excel)
     */
    public function templateAngkatan()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=template_angkatan.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Angkatan'];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Download template Barang (CSV Format yang bisa dibuka Excel)
     */
    public function templateBarang()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=template_barang.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['nama_barang', 'deskripsi_barang', 'stok'];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Proses import Angkatan dari file upload.
     */
    public function importAngkatan(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ], [
            'file.required' => 'Silakan pilih file terlebih dahulu.'
        ]);

        $file = $request->file('file');
        
        // Proses file dengan Maatwebsite Excel (mendukung csv, xls, xlsx)
        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\AngkatanImport, $file);

        return redirect()->route('import.index')->with('success', 'Data Angkatan berhasil di-import.');
    }

    /**
     * Proses import Barang dari file upload.
     */
    public function importBarang(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ], [
            'file.required' => 'Silakan pilih file terlebih dahulu.'
        ]);

        $file = $request->file('file');
        
        // Proses file dengan Maatwebsite Excel (mendukung csv, xls, xlsx)
        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\BarangImport, $file);

        return redirect()->route('import.index')->with('success', 'Data Barang berhasil di-import.');
    }
}
