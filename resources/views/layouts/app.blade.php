<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Donate')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">


    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/homepage/style.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-lg-transparent fixed-top">
        <div class="container">
            <a class="navbar-brand disabled-link" href="#">E-<span>DONATE</span></a>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Script Tambahan -->
    @yield('scripts')
</body>
</html>
