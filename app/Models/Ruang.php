<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruang extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_ruang',
        'keterangan',
        'status_ruang'
    ];

    public function peminjamanruang(): HasMany {
        return $this->hasMany(PeminjamanRuang::class);
    }

    public function jadwal(): hasMany
    {
        return $this->hasMany(JadwalRuangan::class);
    }
}
