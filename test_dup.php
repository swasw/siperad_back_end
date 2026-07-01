<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$konfirmasis = App\Models\JadwalKonfirmasi::where('jadwal_ruangan_id', 1)->get();
echo json_encode($konfirmasis->toArray(), JSON_PRETTY_PRINT);
