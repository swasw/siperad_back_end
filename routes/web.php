<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalRuanganController;
use App\Http\Controllers\JamController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NamaDosenController;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\KehadiranDosenController;
use App\Http\Controllers\PeminjamanRuangController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\RuangController;
use App\Models\JadwalRuangan;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NamaDosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('user/request', function () {
    return view('auth/reset');
})->name('user.request');

Route::controller(ResetController::class)->group(function () {
    Route::post('user/post/request', 'postRequest')->name('user.post.request');
});

Auth::routes();

Route::middleware(['auth', 'user-access:0'])->group(function () {
    Route::get('user/home', [HomeController::class, 'index'])->name('user.home');

    Route::controller(ResetController::class)->group(function () {
        Route::get('user/view/changepass', 'viewChangPass')->name('view.change.pass');
        Route::post('user/post/changepass', 'postChangPass')->name('user.change.pass');
    });
    

    Route::controller(FeedbackController::class)->group(function () {
        Route::get('user/view/feedback', 'viewFeedback')->name('view.feedback');
        Route::post('user/post/feedback', 'store')->name('user.post.feedback');
    });

    Route::controller(NamaDosenController::class)->group(function () {
        Route::get('user/kehadiranDosen', 'viewdosen')->name('user.kehadirandosen');
    });

    Route::controller(JadwalRuanganController::class)->group(function () {
        Route::get('user/lihat-jadwal', 'viewindex')->name('user.lihatjadwal');
        Route::get('user/kalender', 'viewCalendar')->name('user.lihatkalender');
    });

    Route::controller(BarangController::class)->group(function () {
        Route::get('user/lihat-alat', 'index')->name('user.lihatalat');
    });

    Route::controller(PeminjamanBarangController::class)->group(function () {
        Route::get('user/historypeminjamanalat', 'index')->name('user.historypeminjamanalat');
        Route::get('user/formpeminjamanalat', 'create')->name('user.formpeminjamanalat');
        Route::post('user/peminjaman-alat/tambah', 'store')->name('user.peminjaman-alat.store');
    });

    Route::controller(PeminjamanRuangController::class)->group(function () {
        Route::get('user/historypeminjamanruang', 'index')->name('user.historypeminjamanruang');
        Route::get('user/formpeminjamanruang', 'create')->name('user.formpeminjamanruang');
        Route::post('user/peminjaman-ruang/tambah', 'store')->name('user.peminjaman-ruang.store');
    });
});

Route::middleware(['auth', 'user-access:1'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'adminHome'])->name('admin.home');

    // Data Barang
    Route::controller(BarangController::class)->group(function () {
        Route::get('/barang', 'index')->name('barang.index');
        Route::get('/barang/tambah', 'create')->name('barang.create');
        Route::post('/barang/tambah', 'store')->name('barang.store');
        Route::get('/barang/edit/{id}', 'edit')->name('barang.edit');
        Route::put('/barang/edit/{id}', 'update')->name('barang.update');
        Route::delete('/barang/hapus/{id}', 'destroy')->name('barang.destroy');
    });

    // Data Ruang
    Route::controller(RuangController::class)->group(function () {
        Route::get('/ruang', 'index')->name('ruang.index');
        Route::get('/ruang/tambah', 'create')->name('ruang.create');
        Route::post('/ruang/tambah', 'store')->name('ruang.store');
        Route::get('/ruang/edit/{id}', 'edit')->name('ruang.edit');
        Route::put('/ruang/edit/{id}', 'update')->name('ruang.update');
        Route::delete('/ruang/hapus/{id}', 'destroy')->name('ruang.destroy');
    });

    // Data Jam
    Route::controller(JamController::class)->group(function () {
        Route::get('/jam', 'index')->name('jam.index');
        Route::get('/jam/tambah', 'create')->name('jam.create');
        Route::post('/jam/tambah', 'store')->name('jam.store');
        Route::get('/jam/edit/{id}', 'edit')->name('jam.edit');
        Route::put('/jam/edit/{id}', 'update')->name('jam.update');
        Route::delete('/jam/hapus/{id}', 'destroy')->name('jam.destroy');
    });

    // Data Nama Dosen
    Route::controller(NamaDosenController::class)->group(function () {
        Route::get('/dosen', 'index')->name('dosen.index');
        Route::get('/dosen/tambah', 'create')->name('dosen.create');
        Route::post('/dosen/tambah', 'store')->name('dosen.store');
        Route::get('/dosen/edit/{id}', 'edit')->name('dosen.edit');
        Route::put('/dosen/edit/{id}', 'update')->name('dosen.update');
        Route::delete('/dosen/hapus/{id}', 'destroy')->name('dosen.destroy');

        Route::post('/dosen/status', 'ubahstatus')->name('dosen.status');
    });

    // Data Mata Kuliah
    Route::controller(MataKuliahController::class)->group(function () {
        Route::get('/matkul', 'index')->name('matkul.index');
        Route::get('/matkul/tambah', 'create')->name('matkul.create');
        Route::post('/matkul/tambah', 'store')->name('matkul.store');
        Route::get('/matkul/edit/{id}', 'edit')->name('matkul.edit');
        Route::put('/matkul/edit/{id}', 'update')->name('matkul.update');
        Route::delete('/matkul/hapus/{id}', 'destroy')->name('matkul.destroy');
    });

    // Data Jadwal Ruang
    Route::controller(JadwalRuanganController::class)->group(function () {
        Route::get('/jadwal-ruangan', 'index')->name('jadwal-ruangan.index');
        Route::get('/lihat-jadwal-ruangan', 'viewindex')->name('jadwal-ruangan.view');
        Route::get('/jadwal-ruangan/tambah', 'create')->name('jadwal-ruangan.create');
        Route::post('/jadwal-ruangan/tambah', 'store')->name('jadwal-ruangan.store');
        Route::get('/jadwal-ruangan/edit/{id}', 'edit')->name('jadwal-ruangan.edit');
        Route::put('/jadwal-ruangan/edit/{id}', 'update')->name('jadwal-ruangan.update');
        Route::delete('/jadwal-ruangan/hapus/{id}', 'destroy')->name('jadwal-ruangan.destroy');
        Route::delete('/jadwal-ruangan/hapus-semua', 'destroyAll')->name('jadwal-ruangan.destroyall');
    });

    // Data Prodi
    Route::controller(ProdiController::class)->group(function () {
        Route::get('/prodi', 'index')->name('prodi.index');
        Route::get('/prodi/tambah', 'create')->name('prodi.create');
        Route::post('/prodi/tambah', 'store')->name('prodi.store');
        Route::get('/prodi/edit/{id}', 'edit')->name('prodi.edit');
        Route::put('/prodi/edit/{id}', 'update')->name('prodi.update');
        Route::delete('/prodi/hapus/{id}', 'destroy')->name('prodi.destroy');
        // Route::delete('/prodi/hapus-semua', 'destroyAll')->name('prodi.destroyall');
    });

    // Data Angkatan
    Route::controller(AngkatanController::class)->group(function () {
        Route::get('/angkatan', 'index')->name('angkatan.index');
        Route::get('/angkatan/tambah', 'create')->name('angkatan.create');
        Route::post('/angkatan/tambah', 'store')->name('angkatan.store');
        Route::get('/angkatan/edit/{id}', 'edit')->name('angkatan.edit');
        Route::put('/angkatan/edit/{id}', 'update')->name('angkatan.update');
        Route::delete('/angkatan/hapus/{id}', 'destroy')->name('angkatan.destroy');
    });

    // Data Mahasiswa
    Route::controller(MahasiswaController::class)->group(function () {
        Route::get('/mahasiswa', 'index')->name('mahasiswa.index');
        Route::get('/mahasiswa/tambah', 'create')->name('mahasiswa.create');
        Route::post('/mahasiswa/tambah', 'store')->name('mahasiswa.store');
        Route::get('/mahasiswa/edit/{id}', 'edit')->name('mahasiswa.edit');
        Route::put('/mahasiswa/edit/{id}', 'update')->name('mahasiswa.update');
        Route::delete('/mahasiswa/hapus/{id}', 'destroy')->name('mahasiswa.destroy');
    });

    // Data Peminjaman Barang
    Route::controller(PeminjamanBarangController::class)->group(function () {
        Route::get('/peminjaman-barang', 'index')->name('peminjaman-barang.index');
        Route::get('/peminjaman-barang/tambah', 'create')->name('peminjaman-barang.create');
        Route::post('/peminjaman-barang/tambah', 'store')->name('peminjaman-barang.store');
        Route::get('/peminjaman-barang/edit/{id}', 'edit')->name('peminjaman-barang.edit');
        Route::put('/peminjaman-barang/edit/{id}', 'update')->name('peminjaman-barang.update');
        Route::delete('/peminjaman-barang/hapus/{id}', 'destroy')->name('peminjaman-barang.destroy');
    });

    // Data Peminjaman Ruang
    Route::controller(PeminjamanRuangController::class)->group(function () {
        Route::get('/peminjaman-ruang', 'index')->name('peminjaman-ruang.index');
        Route::get('/peminjaman-ruang/tambah', 'create')->name('peminjaman-ruang.create');
        Route::post('/peminjaman-ruang/tambah', 'store')->name('peminjaman-ruang.store');
        Route::get('/peminjaman-ruang/edit/{id}', 'edit')->name('peminjaman-ruang.edit');
        Route::put('/peminjaman-ruang/edit/{id}', 'update')->name('peminjaman-ruang.update');
        Route::delete('/peminjaman-ruang/hapus/{id}', 'destroy')->name('peminjaman-ruang.destroy');
        Route::post('/peminjaman-ruang/status/{id}', 'updateStatus')->name('peminjaman-ruang.status');
    });

    Route::controller(FeedbackController::class)->group(function () {
        Route::get('/feedback', 'index')->name('feedback.index');
        Route::delete('/feedback/hapus/{id}', 'destroy')->name('feedback.destroy');
    });

    // Input Multiple Data / Import
    Route::controller(\App\Http\Controllers\ImportController::class)->group(function () {
        Route::get('/import-data', 'index')->name('import.index');
        Route::post('/import-data/angkatan', 'importAngkatan')->name('import.angkatan');
        Route::post('/import-data/barang', 'importBarang')->name('import.barang');
        Route::get('/import-data/template/angkatan', 'templateAngkatan')->name('import.template.angkatan');
        Route::get('/import-data/template/barang', 'templateBarang')->name('import.template.barang');
    });
});
