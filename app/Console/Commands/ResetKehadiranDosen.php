<?php

namespace App\Console\Commands;

use App\Models\NamaDosen;
use Illuminate\Console\Command;

class ResetKehadiranDosen extends Command
{
    protected $signature = 'dosen:reset-kehadiran';
    protected $description = 'Reset semua kehadiran dosen menjadi 0 setiap hari';

    public function handle()
    {
        NamaDosen::query()->update(['kehadiran_dosen' => 0]);
        $this->info('Kehadiran dosen berhasil direset.');
    }
    
}
