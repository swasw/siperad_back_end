<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>{{ $title }} | UNJ</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/logo-unj.png') }}" />
    <link href="{{ asset('admin/assets/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"
        <script src="{{ url('https://use.fontawesome.com/releases/v6.3.0/js/all.js') }}" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
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
    {{-- Navbar --}}
    @include('admin.partials.navbar')
    <div id="layoutSidenav">
        {{-- Sidenav --}}
        @include('admin.partials.sidenav')
        <div id="layoutSidenav_content">
            @yield('container')

            {{-- Footer --}}
            @include('admin.partials.footer')
        </div>
    </div>

    {{--  Script --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ url('https://kit.fontawesome.com/e632a4a2d6.js') }}" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>s
    <script src="{{ asset('admin/assets/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/assets/assets/demo/chart-bar-demo.js') }}"></script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js') }}"
        crossorigin="anonymous"></script>
    <script src="{{ asset('admin/assets/js/datatables-simple-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
</body>

</html>
