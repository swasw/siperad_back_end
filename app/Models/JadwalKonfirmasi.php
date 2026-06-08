<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKonfirmasi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jadwalRuangan()
    {
        return $this->belongsTo(JadwalRuangan::class, 'jadwal_ruangan_id', 'id');
    }
}
