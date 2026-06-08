<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Angkatan extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'angkatan',

    ];

    public function user(): hasMany
    {
        return $this->hasMany(User::class);
    }
}
