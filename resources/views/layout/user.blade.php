<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('layout.links')
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">
</head>

<body>
    <div id="wrapper">
       
        <div id="page-content-wrapper">
            @include('pages.user.components.navbar')

            {{-- main content --}}
            @yield('user')
            {{-- main content --}}
        </div>
    </div>

    @include('layout.scripts')
    @yield('javascript')
    
</body>

</html>
