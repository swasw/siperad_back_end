<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    // protected $fillable = [
        // 'nama_mahasiswa',
        // 'nim',
        // 'prodi',
        // 'angkatan',

    // ];
    protected $guarded = [];
}
