<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$konfirmasis = App\Models\JadwalKonfirmasi::with('jadwalRuangan')->get();
file_put_contents('output2.json', json_encode($konfirmasis->toArray(), JSON_PRETTY_PRINT));
