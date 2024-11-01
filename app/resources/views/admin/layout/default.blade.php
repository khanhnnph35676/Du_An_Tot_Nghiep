<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('focus-2/focus-2/images/favicon.png') }}">
    <link rel="stylesheet" href="{{asset('focus-2/focus-2/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{asset('focus-2/focus-2/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{asset('focus-2/focus-2/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link href="{{asset('focus-2/focus-2/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('focus-2/focus-2/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    {{--  <link rel="stylesheet" href="{{asset('backend/css/all.min.css')}}"> --}}
    @stack('styleHome')
</head>
<style>
    .my-input {
    border: none; /* Ẩn viền */
    /* Các thuộc tính tùy chỉnh khác để làm đẹp ô input */
    padding: 10px;
    border-radius: 5px;
}

/* Khi ô input được focus (được chọn) */
.my-input:focus {
    border: 1px solid #000000; /* Thêm viền khi focus */
    outline: none; /* Ẩn outline mặc định */
    background-color: #f2f2f2;

}
</style>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('admin.layout.header')

        @include('admin.layout.side-bar')

        @yield('content')

        @include('admin.layout.footer')
    </div>
   <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('focus-2/focus-2/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('focus-2/focus-2/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('focus-2/focus-2/js/custom.min.js') }}"></script>


    <!-- Vectormap -->
    <script src="{{asset('focus-2/focus-2/vendor/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('focus-2/focus-2/vendor/morris/morris.min.js')}}"></script>


    <script src="{{ asset('focus-2/focus-2/vendor/circle-progress/circle-progress.min.js') }} "></script>
    <script src="{{ asset('focus-2/focus-2/vendor/chart.js/Chart.bundle.min.js') }} "></script>

    <script src="{{ asset('focus-2/focus-2/vendor/gaugeJS/dist/gauge.min.js') }}"></script>

    <!--  flot-chart js -->
    <script src=" {{ asset('focus-2/focus-2/vendor/flot/jquery.flot.js') }}"></script>
    <script src=" {{ asset('focus-2/focus-2/vendor/flot/jquery.flot.resize.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('focus-2/focus-2/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>

    <!-- Counter Up -->
    <script src="{{ asset('focus-2/focus-2/vendor/jqvmap/js/jquery.vmap.min.js') }} "></script>
    <script src="{{ asset('focus-2/focus-2/vendor/jqvmap/js/jquery.vmap.usa.js') }} "></script>
    <script src="{{ asset('focus-2/focus-2/vendor/jquery.counterup/jquery.counterup.min.js') }} "></script>


    <script src="{{asset('focus-2/focus-2/js/dashboard/dashboard-1.js')}}"></script>
     <!-- Datatable -->
     <script src="{{ asset('focus-2/focus-2/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('focus-2/focus-2/js/plugins-init/datatables.init.js') }}"></script>


    @stack('scriptHome')
</body>

</html>
