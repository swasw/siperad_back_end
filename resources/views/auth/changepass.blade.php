<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Change Password - SIPERAD</title>
    @include('sweetalert::alert')
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/chartist/css/chartist-custom.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/main.css') }}">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/assets/images/logo-unj.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admin/assets/images/logo-unj.png') }}">

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
            overflow: hidden;
        }

        .bg-cover {
            background: url('{{ asset('admin/assets/images/bg-unj.png') }}') no-repeat center center;
            background-size: cover;
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: right;
            /* Horizontal center */
            align-items: center;
            /* Vertical center */
            position: relative;
        }

        .login-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            max-width: 300px;
            height: 400px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 2;

            /* Perubahan posisi */
            position: relative;
            top: -30px;
            /* Naik ke atas */
            left: -40px;
            /* Geser ke kiri */
        }

        @media (min-width: 768px) {
            .login-card {
                transform: translate(-10px, -20px);
            }
        }

        .login-card {
            transition: transform 0.3s ease-in-out;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .brand-header {
            display: flex;
            align-items: center;
            padding: 20px 30px;
            background: #fff;
            border-bottom: 1px solid #ddd;
        }

        .brand-header img {
            height: 50px;
            margin-right: 15px;
        }

        .brand-header h5 {
            margin: 0;
            font-weight: bold;
        }

        .form-control {
            background-color: #f2f2f2;
            border: none;
        }

        .btn-primary {
            background-color: #1e2b56;
            border: none;
        }

        .login-note {
            font-size: 13px;
            color: #555;
            margin-top: 10px;
        }

        .reset-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body style="overflow: hidden">
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

    <div class="brand-header">
        <img src="{{ asset('admin/assets/images/logo-unj.png') }}" alt="Logo">
        <h5>SIPERAD</h5>
    </div>

    <div class="bg-cover d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="login-card">
            <h4 class="mb-4 text-center">Ubah Password</h4>

            <form method="POST" action="{{ route('user.change.pass') }}">
                @csrf
                <div class="form-group">
                    <label for="signin-password" class="control-label sr-only">Password Lama</label>
                    <input type="password" required autocomplete="current-password" name="old_password"
                        class="form-control @error('old_password') is-invalid @enderror" id="signin-password"
                        placeholder="Password Lama">

                    @error('old_password')
                        <span class="invalid-feedback fs-6 text-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="signin-password" class="control-label sr-only">Password Baru</label>
                    <input type="password" required autocomplete="current-password" name="new_password"
                        class="form-control @error('new_password') is-invalid @enderror" id="signin-password"
                        placeholder="Password Baru">

                    @error('new_password')
                        <span class="invalid-feedback fs-6 text-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="signin-password" class="control-label sr-only">Konfirmasi Password Baru</label>
                    <input type="password" required autocomplete="current-password" name="confirm_password"
                        class="form-control @error('confirm_password') is-invalid @enderror" id="signin-password"
                        placeholder="Konfirmasi Password Baru">

                    @error('confirm_password')
                        <span class="invalid-feedback fs-6 text-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Ubah Password</button>
                <a href="{{ route('user.home') }}" class="btn btn-secondary btn-block mb-2">Back to Home</a>
            </form>
        </div>
    </div>
</body>

</html>
