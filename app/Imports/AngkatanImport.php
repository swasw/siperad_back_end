<?php

namespace App\Imports;

use App\Models\Angkatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AngkatanImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0]) || trim($row[0]) === '') {
            return null;
        }

        return new Angkatan([
            'angkatan' => $row[0],
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
