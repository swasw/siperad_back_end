<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\JadwalKonfirmasi;
use Illuminate\Support\Facades\DB;

// Find duplicates based on jadwal_ruangan_id and tanggal
$duplicates = JadwalKonfirmasi::select('jadwal_ruangan_id', 'tanggal', DB::raw('MIN(id) as min_id'))
    ->groupBy('jadwal_ruangan_id', 'tanggal')
    ->havingRaw('COUNT(id) > 1')
    ->get();

$deleted = 0;
foreach ($duplicates as $dup) {
    // Delete all records with the same jadwal_ruangan_id and tanggal except the one with min_id
    $deleted += JadwalKonfirmasi::where('jadwal_ruangan_id', $dup->jadwal_ruangan_id)
        ->where('tanggal', $dup->tanggal)
        ->where('id', '!=', $dup->min_id)
        ->delete();
}

echo "Deleted $deleted duplicate records.\n";
