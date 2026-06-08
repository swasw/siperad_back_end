<?php



namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Barang;
use App\Models\Jam;
use App\Models\PeminjamanBarang;
use App\Models\Prodi;
use App\Models\Ruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

use App\Models\User;



class CreateUsersSeeder extends Seeder

{
    public function run()
    {
        // Data Barang
        Barang::create([
            'nama_barang' => 'LCD',
            // 'deskripsi_barang' => 'Laptop bertipe os apple yang digunakan untuk bagian programming dan desain, tidak bisa dibuat ngegame',
            'status_barang' => 1,
            'stok' => 3
        ]);
        Barang::create([
            'nama_barang' => 'Alat Tulis',
            // 'deskripsi_barang' => 'Layar untuk PC',
            'status_barang' => 1,
            'stok' => 4
        ]);

        Barang::create([
            'nama_barang' => 'Kabel HDMI',
            // 'deskripsi_barang' => 'Layar untuk PC',
            'status_barang' => 1,
            'stok' => 4
        ]);

        Barang::create([
            'nama_barang' => 'Stop Kontak',
            // 'deskripsi_barang' => 'Layar untuk PC',
            'status_barang' => 1,
            'stok' => 4
        ]);

        // Data Ruang
        Ruang::create([
            'nama_ruang' => 'GDS 507',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);
        Ruang::create([
            'nama_ruang' => 'GDS 508',
            'keterangan' => 'Lab Komputer',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 512',
            'keterangan' => 'Lab Komputer',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 514',
            'keterangan' => 'Lab Komputer',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 515',
            'keterangan' => 'Lab Komputer',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 517',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 607',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 608',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 613',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GDS 614',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GHA 206',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GHA 213',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        Ruang::create([
            'nama_ruang' => 'GHA 411',
            'keterangan' => 'Ruang Belajar',
            'status_ruang' => 1
        ]);

        // Data Jam
        Jam::create([
            'jam' => '07:30',
        ]);
        Jam::create([
            'jam' => '08:00',
        ]);
        Jam::create([
            'jam' => '09:00',
        ]);
        Jam::create([
            'jam' => '10:00',
        ]);
        Jam::create([
            'jam' => '11:00',
        ]);
        Jam::create([
            'jam' => '12:00',
        ]);
        Jam::create([
            'jam' => '13:00',
        ]);
        Jam::create([
            'jam' => '14:00',
        ]);
        Jam::create([
            'jam' => '15:00',
        ]);
        Jam::create([
            'jam' => '16:00',
        ]);
        Jam::create([
            'jam' => '17:00',
        ]);
        Jam::create([
            'jam' => '18:00',
        ]);

        // Data Peminjaman Barang
        // PeminjamanBarang::create([
        //     'nama_peminjam' => 'Yelisha',
        //     'tgl_peminjaman' => '2020-11-21',
        //     'status_peminjaman' => 0
        // ]);

        // Data Peminjaman Ruang
        // PeminjamanRuang::create([
        //     'kode_ruang' => 'RNG-01',
        //     'nama_peminjam' => 'Udin',
        //     'tgl_peminjaman' => '2020-11-21',
        //     'tgl_pengembalian' => '2020-11-29',
        //     'status_peminjaman' => 0
        // ]);

        Prodi::create([
            'nama_prodi' => 'Ilmu Komputer',
        ]);

        Prodi::create([
            'nama_prodi' => 'Pendidikan Matematika',
        ]);

        Prodi::create([
            'nama_prodi' => 'Statistika',
        ]);

        Prodi::create([
            'nama_prodi' => 'Matematika',
        ]);

        Angkatan::create([
            'angkatan' => '2021',
        ]);

        Angkatan::create([
            'angkatan' => '2022',
        ]);

        Angkatan::create([
            'angkatan' => '2023',
        ]);

        Angkatan::create([
            'angkatan' => '2024',
        ]);

        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'type' => 1,
                'password' => bcrypt('123456'),
                'prodi_id' => '1',
                'angkatan_id' => '1',
            ],
            [
                'name' => 'Ridwan',
                'username' => '1313618016',
                'email' => 'user@gmail.com',
                'type' => 0,
                'password' => bcrypt('123456'),
                'prodi_id' => '1',
                'angkatan_id' => '1',
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
