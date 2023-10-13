<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluation | {{ ucwords(Request::segment(1)) }}</title>
    @include('layout.links')
    <link rel="icon" href="storage/img/main/basc.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @yield('custom_css')
</head>

<body>
    <div class="d-flex" id="wrapper">
        @include('pages.admin.components.sidebar')
        <div id="page-content-wrapper">
            @include('pages.admin.components.navbar')

            {{-- main content --}}
            @yield('admin')
            {{-- main content --}}
        </div>
    </div>

    @include('layout.scripts')
    @include('pages.admin.components.sweet_alert_msg')
    @yield('javascript')

</body>

</html>
