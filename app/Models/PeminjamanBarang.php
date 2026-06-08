<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeminjamanBarang extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'tgl_peminjaman',
        'nama_peminjam',
        'nim',
        'no_hp',
        'prodi_id',
        'angkatan_id',
        'matkul_id',
        'dosen_id',
        'barang_id',
        'status_peminjaman'
    ];

    public function Prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function Angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }

    public function Barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function Matkul()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function Dosen()
    {
        return $this->belongsTo(NamaDosen::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
