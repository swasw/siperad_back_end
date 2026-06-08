<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login - SIPERAD</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/chartist/css/chartist-custom.css') }}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/main.css') }}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admin/assets/img/favicon.png') }}">
    <link type="text/css" href=
"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @if (session('alert'))
        {{-- @dd(session('alert')) --}}
        <script>
            Swal.fire({
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.text') }}',
                icon: '{{ session('alert.icon') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
                <div class="auth-box ">
                    <div class="left">
                        <div class="content">
                            <div class="header">
                                <p class="lead">Reset</p>
                            </div>
                            <form class="form-auth-small" method="POST" action="{{ route('user.post.request') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label sr-only">Username / NIM</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" value="{{ old('username') }}" required autocomplete="username"
                                        id="username" placeholder="Username / NIM" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="btn btn-primary btn-lg btn-block">{{ __('Request') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="overlay"></div>
                        {{-- <div class="content text">
                            <h1 class="heading">SIPERAD</h1>

                        </div> --}}
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
    <input type="" name="" id="txtDate" runat="server" />

    <script type="text/javascript">
        $(function() {
            $("#txtDate").datepicker({
                dateFormat: 'dd/mm/yy'
            });
        });
    </script>
</body>

</html>
