<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NamaDosen extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_dosen',
        'kehadiran_dosen'
    ];

    public function jadwal(): hasMany
    {
        return $this->hasMany(JadwalRuangan::class);
    }
}
