<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'tgl_feedback',
        'nama',
        'kategori',
        'saran',
    ];
}
