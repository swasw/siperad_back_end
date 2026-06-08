<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SIPERAD - UNJ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/img/logo-unj.png') }}" />
    <link href="{{ asset('frontend/assets/img/logo-unj.png') }}" rel="icon">

    <link href="{{ asset('frontend/assets/img/logo-unj.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/owl.carouselfrontend/assets/owl.carousel.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('admin/assets/css/styles.css') }}" rel="stylesheet"> --}}

    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/login-style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Scaffold - v2.2.1
  * Template URL: https://bootstrapmade.com/scaffold-bootstrap-metro-style-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    @include('sweetalert::alert')
    @if (session('alert'))
        <script>
            Swal.fire({
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.text') }}',
                icon: '{{ session('alert.icon') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex">

            <div class="logo mr-auto">
                <a class="navbar-brand" href="{{ route('user.home') }}">
                    <img src="{{ asset('frontend/assets/img/logo-unj.png') }}" width="40" height="60"
                        alt="">
                </a>
            </div>

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="{{ request()->routeIs('user.home') ? 'active' : '' }}">
                        <a href="{{ route('user.home') }}">
                            <span class="menu-title">Home</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.lihatalat') ? 'active' : '' }}">
                        <a href="{{ route('user.lihatalat') }}">
                            <span class="menu-title">Ketersediaan Alat</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.lihatkalender') ? 'active' : '' }}">
                        <a href="{{ route('user.lihatkalender') }}">
                            <span class="menu-title">Ketersediaan Ruangan</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.lihatjadwal') ? 'active' : '' }}">
                        <a href="{{ route('user.lihatjadwal') }}">
                            <span class="menu-title">Jadwal Kelas</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.kehadirandosen') ? 'active' : '' }}">
                        <a href="{{ route('user.kehadirandosen') }}">
                            <span class="menu-title">Kehadiran Dosen</span>
                        </a>
                    </li>
                    <li class="drop-down {{ request()->routeIs('user.historypeminjamanalat', 'user.historypeminjamanruang') ? 'active' : '' }}">
                        <a href="#"><span class="menu-title">Status</span></a>
                        <ul>
                            <li class="{{ request()->routeIs('user.historypeminjamanalat') ? 'active' : '' }}">
                                <a href="{{ route('user.historypeminjamanalat') }}">Peminjaman Alat</a>
                            </li>
                            <li class="{{ request()->routeIs('user.historypeminjamanruang') ? 'active' : '' }}">
                                <a href="{{ route('user.historypeminjamanruang') }}">Peminjaman Ruang</a>
                            </li>
                        </ul>
                    </li>

                    <li class="drop-down"><a href="#">
                            @php
                                $fullName = Auth()->user()->name;
                                $firstName = explode(' ', trim($fullName))[0];
                            @endphp
                            {{ $firstName }}</a>
                        <ul>
                            <li><a href=" {{ route('view.feedback') }}">Feedback</a></li>
                            <li><a href=" {{ route('view.change.pass') }}">Ubah Password</a></li>
                            <li>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- Tombol Logout -->


                    <!-- Form Logout Tersembunyi -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->

    <section id="content">
        @yield('content')
    </section>
    <!-- ======= Footer ======= -->

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <!-- Logo & Deskripsi -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <img src="{{ asset('frontend/assets/img/logo-unj.png') }}" alt="Logo UNJ" style="width: 80px;">
                        <p class="mt-3">
                            Universitas Negeri Jakarta adalah perguruan tinggi negeri yang terdapat di Kota Jakarta,
                            Indonesia yang didirikan pada tahun 1964.
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">

                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">

                    </div>

                    <!-- Alamat & Jam -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="fw-bold">Alamat Kami</h5>
                        <p class="mt-2">
                            Jl. Rawamangun Muka, RT.11/RW14,<br>
                            Rawamangun, Pulo Gadung, Jakarta Timur,<br>
                            Daerah Khusus Jakarta, 13320
                        </p>
                        <h5 class="fw-bold mt-3">Jam Kerja</h5>
                        <p class="mt-2">
                            Senin-Jum'at, 08.00-16.00 WIB<br>
                            Sabtu, Minggu dan Tanggal Merah, <strong>Tutup</strong>
                        </p>
                    </div>
                </div>

                <div class="text-center mt-4 pt-3">
                    <p class="mb-0">&copy; 2024 UNJ, All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <a href="#" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Template Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>

</html>
