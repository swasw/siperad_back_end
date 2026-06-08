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
            'file' => 'required|mimes:csv,txt,xlsx,xls'
        ], [
            'file.required' => 'Silakan pilih file terlebih dahulu.',
            'file.mimes' => 'File harus berformat csv, txt, xls, atau xlsx.'
        ]);

        $file = $request->file('file');
        
        // Baca file sebagai CSV (karena kita arahkan user upload CSV)
        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            $header = true;
            // Support delimiter koma (,) atau titik koma (;)
            $delimiter = ',';
            
            while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                // Auto-detect delimiter pada baris pertama jika memungkinkan
                if ($header && count($data) == 1 && strpos($data[0], ';') !== false) {
                    $delimiter = ';';
                    $data = explode(';', $data[0]);
                }
                
                if ($header) {
                    $header = false;
                    continue; // Lewati baris pertama (header)
                }

                // Cek agar tidak error jika row kosong
                if (!isset($data[0]) || trim($data[0]) === '') {
                    continue;
                }

                Angkatan::create([
                    'angkatan' => $data[0]
                ]);
            }
            fclose($handle);
        }

        return redirect()->route('import.index')->with('success', 'Data Angkatan berhasil di-import.');
    }

    /**
     * Proses import Barang dari file upload.
     */
    public function importBarang(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls'
        ], [
            'file.required' => 'Silakan pilih file terlebih dahulu.',
            'file.mimes' => 'File harus berformat csv, txt, xls, atau xlsx.'
        ]);

        $file = $request->file('file');
        
        // Baca file sebagai CSV
        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            $header = true;
            $delimiter = ',';
            
            while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                // Auto-detect delimiter
                if ($header && count($data) == 1 && strpos($data[0], ';') !== false) {
                    $delimiter = ';';
                    $data = explode(';', $data[0]);
                }

                if ($header) {
                    $header = false;
                    continue; // Lewati baris pertama (header)
                }

                if (!isset($data[0]) || trim($data[0]) === '') {
                    continue;
                }

                Barang::create([
                    'nama_barang' => $data[0] ?? '-',
                    'deskripsi_barang' => $data[1] ?? '-',
                    'status_barang' => 'Tersedia', // Default
                    'stok' => $data[2] ?? 0
                ]);
            }
            fclose($handle);
        }

        return redirect()->route('import.index')->with('success', 'Data Barang berhasil di-import.');
    }
}
