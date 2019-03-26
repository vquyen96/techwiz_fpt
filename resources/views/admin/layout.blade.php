<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> @yield('title') </title>
        <!-- Google Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
        <script>
            WebFont.load({
                google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
        <!-- Stylesheet -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/base/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/base/elisyam-1.5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/widgets/header.css') }}">
        <!-- Custom stylesheet -->
        @yield('style')

        <!-- Tweaks for older IEs-->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-white">
        <!-- Begin Preloader -->
        <div id="preloader">
            <div class="canvas">
                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="loader-logo">
                <div class="spinner"></div>
            </div>
        </div>
        <!-- End Preloader -->

        <!-- Begin Container -->
        @yield('content')
        <!-- End Container -->

        <!-- Begin Vendor Js -->
        <script src="{{ asset('assets/vendors/js/base/jquery.min.js') }}"></script>
        {{--<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>--}}
        <script src="{{ asset('assets/admin/js/widgets/script.js') }}"></script>
        <script src="{{ asset('assets/vendors/js/base/core.min.js') }}"></script>
        <!-- End Vendor Js -->

        <!-- Begin Page Vendor Js -->
        <script src="{{ asset('assets/vendors/js/nicescroll/nicescroll.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/js/noty/noty.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/js/app/app.min.js') }}"></script>
        <!-- End Page Vendor Js -->

        <!-- Noty flash messages -->
        <script type="application/javascript">
            @foreach (['notification', 'success', 'warning', 'error', 'info'] as $type)
                @if(Session::has($type))
                    new Noty({
                        type: '{{ $type }}',
                        layout: 'topRight',
                        text: '{{ Session::get($type) }}',
                        progressBar: true,
                        timeout: 5000,
                        animation: {
                            open: 'animated bounceInRight',
                            close: 'animated bounceOutRight'
                        }
                    }).show();
                @endif
            @endforeach
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: '{{ $error }}',
                        progressBar: true,
                        timeout: 5000,
                        animation: {
                            open: 'animated bounceInRight',
                            close: 'animated bounceOutRight'
                        }
                    }).show();
                @endforeach
            @endif
        </script>
        {{--<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>--}}
        {{--<script src="{{ asset('assets/admin/js/widgets/script.js') }}"></script>--}}

        <!-- Custom script -->
        @yield('script')
    </body>
</html>
