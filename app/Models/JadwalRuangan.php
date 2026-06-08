<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalRuangan extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'ruang_id',
        'hari',
        'status_ruang',
        'user_id',
        'mata_kuliah',
        'dosen',
        'prodi',
        'angkatan',
        'kelas',
        'jam_mulai_ke',
        'jam_selesai_ke',
        'jam_mulai',
        'jam_selesai',
    ];

    public function Ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function Penanggungjawab()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
