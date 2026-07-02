<?php

namespace App\Imports;

use App\Models\Barang;
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
        // Pastikan nama barang tidak kosong
        if (!isset($row[0]) || trim($row[0]) === '') {
            return null;
        }

        return new Barang([
            'nama_barang' => $row[0] ?? '-',
            'deskripsi_barang' => $row[1] ?? '-',
            'status_barang' => 'Tersedia', // Default
            'stok' => $row[2] ?? 0
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Mulai dari baris ke-2 karena baris 1 adalah header
    }
}
