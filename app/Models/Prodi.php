<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_prodi',

    ];

    public function user(): hasMany
    {
        return $this->hasMany(User::class);
    }

    public function jadwal(): hasMany
    {
        return $this->hasMany(JadwalRuangan::class);
    }
}
