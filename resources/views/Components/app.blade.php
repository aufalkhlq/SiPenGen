<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="{{ asset('/assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
   
</head>

<body>
    <div class="main-wrapper">
        @include('components.header')
        <div class="sidebar" id="sidebar">
            @include('components.sidebar')
        </div>

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('/assets/js/script.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/datatables.min.js') }}"></script>
</body>

</html>
