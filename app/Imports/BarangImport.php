<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BarangImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip jika baris benar-benar kosong
        if (!isset($row[0]) || trim($row[0]) === '') {
            return null;
        }

        // Tiru validasi persis seperti di BarangController@store
        $validator = Validator::make([
            'nama_barang' => $row[0] ?? '',
            'deskripsi_barang' => $row[1] ?? '-',
            'stok' => $row[2] ?? 0,
        ], [
            'nama_barang' => ['required', 'max:100'],
            'deskripsi_barang' => ['required', 'max:100'],
            'stok' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return null; // Abaikan baris ini jika tidak valid (atau bisa dilempar sebagai error)
        }

        // Sama persis seperti fungsi manual: menggunakan Barang::create / updateOrCreate
        // Kita pakai updateOrCreate agar kalau nama alat sama persis, dia hanya update stoknya (mencegah error ganda)
        return Barang::updateOrCreate(
            ['nama_barang' => $row[0]],
            [
                'deskripsi_barang' => $row[1] ?? '-',
                'status_barang' => 1, // Status default: 1 (Tersedia) persis seperti form manual yang checked = 1
                'stok' => (int) ($row[2] ?? 0)
            ]
        );
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Mulai dari baris ke-2 (Baris 1 = Header)
    }
}
