@extends('user.layouts.frontend')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        @if (session('alert.config'))
            @php
                $config = json_decode(session('alert.config'), true);
            @endphp
            <script>
                Swal.fire({
                    title: '{{ $config['title'] ?? '' }}',
                    text: '{{ $config['text'] ?? '' }}',
                    icon: '{{ $config['icon'] ?? 'success' }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif


        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="fade-up">
                        <div>
                            <h1>Selamat Datang di Sistem Peminjaman Ruang dan Alat serta Kehadiran Dosen</h1>
                            <h2>Rumpun Matematika Universitas Negeri Jakarta</h2>

                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
                        <img src="{{ asset('frontend/assets/img/hero-img.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Tatacara Section ======= -->
        <section id="tatacara" class="tatacara">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6" data-aos="zoom-in">
                        <img src="{{ asset('frontend/assets/img/about.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                        <div class="content pt-4 pt-lg-0">
                            <h3>Panduan Penggunaan Sistem</h3>
                            <p class="font-italic">
                                Sistem informasi ini dibuat untuk memfasilitasi peminjaman ruang dan alat oleh mahasiswa
                                serta staf Universitas Negeri Jakarta. Berikut panduan penggunaannya:
                            </p>
                            <ul>
                                <li><i class="icofont-check-circled"></i> <strong>Peminjaman Alat:</strong> Mahasiswa harus
                                    berada di kampus, mengisi form peminjaman alat, lalu mengambil barang di ruangan admin
                                    dengan menyerahkan KTM sebagai penjamin.</li>
                                <li><i class="icofont-check-circled"></i> <strong>Peminjaman Ruangan:</strong> Mahasiswa
                                    wajib mengecek jadwal kelas terlebih dahulu untuk mengetahui ruangan dan jam kosong.
                                    Setelah itu, cek di menu ketersediaan ruangan. Jika ruangan dan jam tersebut belum
                                    dipesan, maka mahasiswa dapat mengisi form peminjaman.</li>
                                <li><i class="icofont-check-circled"></i> <strong>Melihat Kehadiran Dosen:</strong> Gunakan
                                    menu <em>Kehadiran Dosen</em> untuk melihat informasi dosen yang hadir di kampus.</li>
                                <li><i class="icofont-check-circled"></i> <strong>Melihat Status Peminjaman:</strong>
                                    Mahasiswa dapat mengecek status peminjaman melalui menu <em>Status</em>, lalu pilih
                                    antara status peminjaman alat atau ruangan.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Tatacara Section -->
    </main><!-- End #main -->
@stop
