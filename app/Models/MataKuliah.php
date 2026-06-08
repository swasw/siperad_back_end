<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'mata_kuliah',
    ];

    public function jadwal(): hasMany
    {
        return $this->hasMany(JadwalRuangan::class);
    }
}
