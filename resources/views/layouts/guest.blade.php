<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}
{{--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}
    <title>{{ config('app.name', 'WT&P Management System') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    {{--    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <style>
        .myForm {
            /*min-width: 500px;*/
            position: absolute;
            text-align: center;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            /*font-size: 2.5rem*/
        }
        @media (max-width: 500px) {
            .myForm {
                min-width: 90%;
            }
        }

        .customPrimaryColor{
            background-color: #f76440!important;
        }

        .customColor{
            color: #f76440!important;
        }

    </style>
</head>

<body class="hold-transition sidebar-mini">
@auth
    @include('layouts.shared.nav')
@endauth
<div class="py-5">
    {{ $slot }}
</div>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
