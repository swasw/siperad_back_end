<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeminjamanRuang extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_peminjam',
        'tgl_peminjaman',
        'jam_mulai_id',
        'jam_selesai_id',
        'ruang_id',
        'status_peminjaman',
        'mata_kuliah',
        'dosen',
        'prodi',
        'angkatan',
    ];

    public function Ruang()
    {
        return $this->belongsTo(Ruang::class);
    }



    public function Jamx()
    {
        return $this->belongsTo(Jam::class, 'jam_mulai_id');
    }

    public function Jamy()
    {
        return $this->belongsTo(Jam::class, 'jam_selesai_id');
    }
}
