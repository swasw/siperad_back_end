<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jam extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'jam',

    ];

    public function jam(): hasMany
    {
        return $this->hasMany(User::class);
    }

    public function jadwalMulai(): hasMany
    {
        return $this->hasMany(JadwalRuangan::class);
    }

    public function jadwalSelesai(): hasMany
    {
        return $this->hasMany(JadwalRuangan::class);
    }
}
