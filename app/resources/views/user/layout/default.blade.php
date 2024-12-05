<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Fruitables - Vegetable Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet"> --}}

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('store/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('store/lib/owlcarousel/assets/owl.carousel.min.css') }} " rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('store/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('store/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        @stack('styleStore')
    </head>

    <body>
        @include('user.layout.header')

        @yield('content')

        @include('user.layout.footer')
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="{{ asset('store/js/bootstrap.bundle.min.js') }}"></script>
    <script src=" {{ asset('store/lib/easing/easing.min.js ') }} "></script>
    <script src=" {{ asset('store/lib/waypoints/waypoints.min.js ') }} "></script>
    <script src=" {{ asset('store/lib/lightbox/js/lightbox.min.js ') }} "></script>
    <script src=" {{ asset('store/lib/owlcarousel/owl.carousel.min.js ') }} "></script>
    <!-- Template Javascript -->
    <script src="{{ asset('store/js/main.js ') }}"></script>
    @stack('scriptStore')
    </body>
</html>
