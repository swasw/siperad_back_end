<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\FunctionAPIController;
use App\Http\Controllers\RuangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(FunctionAPIController::class)->group(function () {
    Route::get('/alat/index', 'indexAlat');
    Route::post('/alat/post', 'storeAlat');
    Route::get('/alat/{id}', 'getAlat');
    Route::put('/alat/{id}', 'updateAlat');
    Route::delete('/alat/{id}', 'destroyAlat');

    Route::get('/peminjamanalat/index', 'indexPeminjamanAlat');
    Route::post('/peminjamanalat/post', 'storePeminjamanAlat');
    Route::get('/peminjamanalat/{id}', 'getPeminjamanAlat');
    Route::put('/peminjamanalat/{id}', 'updatePeminjamanAlat');
    Route::delete('/peminjamanalat/{id}', 'destroyPeminjamanAlat');

    Route::get('/ruang/index', 'indexRuang');
    Route::post('/ruang/post', 'storeRuang');
    Route::get('/ruang/{id}', 'getRuang');
    Route::put('/ruang/{id}', 'updateRuang');
    Route::delete('/ruang/{id}', 'destroyRuang');

    Route::get('/peminjamanruang/index', 'indexPeminjamanRuang');
    Route::post('/peminjamanruang/post', 'storePeminjamanRuang');
    Route::get('/peminjamanruang/{id}', 'getPeminjamanRuang');
    Route::put('/peminjamanruang/{id}', 'updatePeminjamanRuang');
    Route::delete('/peminjamanruang/{id}', 'destroyPeminjamanRuang');
    Route::put('/peminjamanruang/status/{id}', 'updateStatusPeminjamanRuang');

    Route::get('/jadwalruang/index', 'indexJadwalRuang');
    Route::get('/lihat-jadwalruang/index', 'viewIndexJadwalRuang');
    Route::get('/lihat/kalender', 'viewCalendar');
    Route::post('/jadwalruang/post', 'storeJadwalRuang');
    Route::get('/jadwalruang/{id}', 'getJadwalRuang');
    Route::put('/jadwalruang/{id}', 'updateJadwalRuang');
    Route::delete('/jadwalruang/hapus-semua', 'destroyAllJadwalRuang');
    Route::delete('/jadwalruang/{id}', 'destroyJadwalRuang');
    
    Route::get('/matakuliah/index', 'indexMataKuliah');
    Route::post('/matakuliah/post', 'storeMataKuliah');
    Route::get('/matakuliah/{id}', 'getMataKuliah');
    Route::put('/matakuliah/{id}', 'updateMataKuliah');
    Route::delete('/matakuliah/{id}', 'destroyMataKuliah');

    Route::get('/dosen/index', 'indexDosen');
    Route::post('/dosen/post', 'storeDosen');
    Route::post('/dosen/status', 'ubahStatus');
    Route::get('/dosen/{id}', 'getDosen');
    Route::put('/dosen/{id}', 'updateDosen');
    Route::delete('/dosen/{id}', 'destroyDosen');
    
    Route::get('/jam/index', 'indexJam');
    Route::post('/jam/post', 'storeJam');
    Route::get('/jam/{id}', 'getJam');
    Route::put('/jam/{id}', 'updateJam');
    Route::delete('/jam/{id}', 'destroyJam');

    Route::get('/prodi/index', 'indexProdi');
    Route::post('/prodi/post', 'storeProdi');
    Route::get('/prodi/{id}', 'getProdi');
    Route::put('/prodi/{id}', 'updateProdi');
    Route::delete('/prodi/{id}', 'destroyProdi');

    Route::get('/angkatan/index', 'indexAngkatan');
    Route::post('/angkatan/post', 'storeAngkatan');
    Route::get('/angkatan/{id}', 'getAngkatan');
    Route::put('/angkatan/{id}', 'updateAngkatan');
    Route::delete('/angkatan/{id}', 'destroyAngkatan');

    Route::get('/mahasiswa/index', 'indexMahasiswa');
    Route::post('/mahasiswa/post', 'storeMahasiswa');
    Route::get('/mahasiswa/{id}', 'getMahasiswa');
    Route::put('/mahasiswa/{id}', 'updateMahasiswa');
    Route::delete('/mahasiswa/{id}', 'destroyMahasiswa');

    Route::get('/feedback/index', 'indexFeedback');
    Route::post('/feedback/post', 'storeFeedback');
    Route::get('/feedback/{id}', 'getFeedback');
    Route::post('/push-subscription/save', 'savePushSubscription');
    Route::post('/konfirmasi-ruangan/submit', 'submitKonfirmasi');
    Route::get('/konfirmasi-ruangan/list/{user_id}', 'listKonfirmasi');
    Route::get('/konfirmasi-ruangan/all', 'listSemuaKonfirmasi');
});
