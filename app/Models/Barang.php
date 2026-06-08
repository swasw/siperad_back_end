<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_barang',
        'deskripsi_barang',
        'status_barang',
        'stok'
    ];

    public function peminjamanbarang(): hasMany
    {
        return $this->hasMany(PeminjamanBarang::class);
    }

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
