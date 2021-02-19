<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}"/>
    <meta name="keywords" content="HTML5 Template , Responsive , html5 , css3"/>
    <meta name="description" content="{{env('APP_TITLE')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap-3.3.7 fremwork css -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/glyphicons.css')}}"/>
    <!-- Core Style css -->
    <link rel="stylesheet" href="{{asset('css/colorbox.css')}}"/>
    <!-- Slider carousel css  -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
    <!-- Slider revolution css  -->
    <link rel="stylesheet" href="{{asset('vendor/rs-plugin/css/settings.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/rev-settings.css')}}"/>
    <!-- Fontawesome 5.10.1 -->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome/css/all.css')}}">
    <!-- Main style css -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>

    <!-- modal -->
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">
    <!-- ajax-loader -->
    <link rel="stylesheet" href="{{asset('css/ajax-loader.css')}}">
    <!-- select2 -->
    <link href="{{asset('vendor/select2/dist/css/select2.css')}}" rel="stylesheet"/>
    <!-- Loading.io -->
    <link href="{{asset('css/loading.css')}}" rel="stylesheet">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{asset('vendor/sweetalert/sweetalert2.css')}}">
    <!-- Media queries -->
    <link rel="stylesheet" href="{{asset('css/media-query.css')}}">

    <style>
        ::selection {
            background: #122752;
            color: #fff;
        }

        ::-moz-selection {
            background: #122752;
            color: #fff;
        }

        .avatar img {
            width: 40px;
            margin-right: .5em;
            border-radius: 100%;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .avatar:hover img {
            border: 1px solid #122752;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .m-0 {
            margin: 0 !important;
        }

        .mt-0,
        .my-0 {
            margin-top: 0 !important;
        }

        .mr-0,
        .mx-0 {
            margin-right: 0 !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .ml-0,
        .mx-0 {
            margin-left: 0 !important;
        }

        .m-1 {
            margin: 0.25rem !important;
        }

        .mt-1,
        .my-1 {
            margin-top: 0.25rem !important;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem !important;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem !important;
        }

        .ml-1,
        .mx-1 {
            margin-left: 0.25rem !important;
        }

        .m-2 {
            margin: 0.5rem !important;
        }

        .mt-2,
        .my-2 {
            margin-top: 0.5rem !important;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem !important;
        }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5rem !important;
        }

        .ml-2,
        .mx-2 {
            margin-left: 0.5rem !important;
        }

        .m-3 {
            margin: 1rem !important;
        }

        .mt-3,
        .my-3 {
            margin-top: 1rem !important;
        }

        .mr-3,
        .mx-3 {
            margin-right: 1rem !important;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .ml-3,
        .mx-3 {
            margin-left: 1rem !important;
        }

        .m-4 {
            margin: 1.5rem !important;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem !important;
        }

        .mr-4,
        .mx-4 {
            margin-right: 1.5rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        .ml-4,
        .mx-4 {
            margin-left: 1.5rem !important;
        }

        .m-5 {
            margin: 3rem !important;
        }

        .mt-5,
        .my-5 {
            margin-top: 3rem !important;
        }

        .mr-5,
        .mx-5 {
            margin-right: 3rem !important;
        }

        .mb-5,
        .my-5 {
            margin-bottom: 3rem !important;
        }

        .ml-5,
        .mx-5 {
            margin-left: 3rem !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        .pt-0,
        .py-0 {
            padding-top: 0 !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pb-0,
        .py-0 {
            padding-bottom: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .p-1 {
            padding: 0.25rem !important;
        }

        .pt-1,
        .py-1 {
            padding-top: 0.25rem !important;
        }

        .pr-1,
        .px-1 {
            padding-right: 0.25rem !important;
        }

        .pb-1,
        .py-1 {
            padding-bottom: 0.25rem !important;
        }

        .pl-1,
        .px-1 {
            padding-left: 0.25rem !important;
        }

        .p-2 {
            padding: 0.5rem !important;
        }

        .pt-2,
        .py-2 {
            padding-top: 0.5rem !important;
        }

        .pr-2,
        .px-2 {
            padding-right: 0.5rem !important;
        }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5rem !important;
        }

        .pl-2,
        .px-2 {
            padding-left: 0.5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .pt-3,
        .py-3 {
            padding-top: 1rem !important;
        }

        .pr-3,
        .px-3 {
            padding-right: 1rem !important;
        }

        .pb-3,
        .py-3 {
            padding-bottom: 1rem !important;
        }

        .pl-3,
        .px-3 {
            padding-left: 1rem !important;
        }

        .p-4 {
            padding: 1.5rem !important;
        }

        .pt-4,
        .py-4 {
            padding-top: 1.5rem !important;
        }

        .pr-4,
        .px-4 {
            padding-right: 1.5rem !important;
        }

        .pb-4,
        .py-4 {
            padding-bottom: 1.5rem !important;
        }

        .pl-4,
        .px-4 {
            padding-left: 1.5rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        .pt-5,
        .py-5 {
            padding-top: 3rem !important;
        }

        .pr-5,
        .px-5 {
            padding-right: 3rem !important;
        }

        .pb-5,
        .py-5 {
            padding-bottom: 3rem !important;
        }

        .pl-5,
        .px-5 {
            padding-left: 3rem !important;
        }

        .float-left {
            float: left !important
        }

        .required {
            color: #122752;
        }

        .has-feedback .form-control-feedback {
            position: absolute;
            display: block;
            width: 45px;
            height: 45px;
            line-height: 45px;
            text-align: center;
        }

        .custom-control {
            position: relative;
            display: block;
            min-height: 1.5rem;
            /*padding-left: 1.5rem;*/
        }

        .custom-control-inline {
            display: -ms-inline-flexbox;
            display: inline-flex;
            margin-right: 1rem;
        }

        .custom-control-input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .custom-control-input:checked ~ .custom-control-label::before {
            color: #fff;
            background-color: #122752;
        }

        .custom-control-input:focus ~ .custom-control-label::before {
            box-shadow: 0 0 0 1px #fff, 0 0 0 0.2rem rgba(18, 39, 82, 0.25);
        }

        .custom-control-input:active ~ .custom-control-label::before {
            color: #fff;
            background-color: #377aff;
        }

        .custom-control-input:disabled ~ .custom-control-label {
            color: #6c757d;
        }

        .custom-control-input:disabled ~ .custom-control-label::before {
            background-color: #e9ecef;
        }

        .custom-control-label {
            position: relative;
            margin-bottom: 0;
        }

        .custom-control-label::before {
            position: absolute;
            top: 0.25rem;
            left: -2rem;
            display: block;
            width: 1.5rem;
            height: 1.5rem;
            pointer-events: none;
            content: "";
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #dee2e6;
        }

        .custom-control-label::after {
            position: absolute;
            top: 0.25rem;
            left: -2rem;
            display: block;
            width: 1.5rem;
            height: 1.5rem;
            content: "";
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 50% 50%;
        }

        .custom-checkbox .custom-control-label::before {
            border-radius: 0.25rem;
        }

        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #122752;
        }

        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::after {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E");
        }

        .custom-checkbox .custom-control-input:indeterminate ~ .custom-control-label::before {
            background-color: #122752;
        }

        .custom-checkbox .custom-control-input:indeterminate ~ .custom-control-label::after {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 4'%3E%3Cpath stroke='%23fff' d='M0 2h4'/%3E%3C/svg%3E");
        }

        .custom-checkbox .custom-control-input:disabled:checked ~ .custom-control-label::before {
            background-color: rgba(18, 39, 82, 0.5);
        }

        .custom-checkbox .custom-control-input:disabled:indeterminate ~ .custom-control-label::before {
            background-color: rgba(18, 39, 82, 0.5);
        }

        .custom-radio .custom-control-label::before {
            border-radius: 50%;
        }

        .custom-radio .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #122752;
        }

        .custom-radio .custom-control-input:checked ~ .custom-control-label::after {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23fff'/%3E%3C/svg%3E");
        }

        .custom-radio .custom-control-input:disabled:checked ~ .custom-control-label::before {
            background-color: rgba(18, 39, 82, 0.5);
        }

        .btn-primary {
            background-color: #122752;
            border-color: #112141;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary.focus,
        .btn-primary:active,
        .btn-primary.active,
        .open > .dropdown-toggle.btn-primary {
            background-color: #112141;
            border-color: #0d1223;
        }

        .btn-primary.disabled,
        .btn-primary[disabled],
        fieldset[disabled] .btn-primary,
        .btn-primary.disabled:hover,
        .btn-primary[disabled]:hover,
        fieldset[disabled] .btn-primary:hover,
        .btn-primary.disabled:focus,
        .btn-primary[disabled]:focus,
        fieldset[disabled] .btn-primary:focus,
        .btn-primary.disabled.focus,
        .btn-primary[disabled].focus,
        fieldset[disabled] .btn-primary.focus,
        .btn-primary.disabled:active,
        .btn-primary[disabled]:active,
        fieldset[disabled] .btn-primary:active,
        .btn-primary.disabled.active,
        .btn-primary[disabled].active,
        fieldset[disabled] .btn-primary.active {
            background-color: #122752;
            border-color: #112141;
        }

        .pagination > li > a,
        .pagination > li > span {
            color: #777;
            background-color: #fff;
            border: 1px solid #ddd;
            font-weight: 600;
        }

        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #0f1c37;
        }

        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            background-color: #122752;
            border-color: #122752;
        }

        .pagination > .disabled > a,
        .pagination > .disabled > a:focus,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > span,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > span:hover {
            pointer-events: none;
        }

        .select2-selection {
            height: auto !important;
        }

        .btn-primary .badge {
            color: #122752;
            background-color: #fff;
        }

        .swal-button--confirm, .swal-button--edit {
            background-color: #122752;
            border: 1px solid #122752;
            box-shadow: 0 2px 6px #1b3a87;
        }

        .swal-button--confirm:active, .swal-button--edit:active {
            background-color: #122752;
        }

        .load {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
        }

        .load hr {
            border: 0;
            margin: 0;
            width: 40%;
            height: 40%;
            position: absolute;
            border-radius: 50%;
            animation: spin 4s ease infinite;
        }

        .load :first-child {
            background: #3776ff;
            animation-delay: -3s;
        }

        .load :nth-child(2) {
            background: #2251b6;
            animation-delay: -2s;
        }

        .load :nth-child(3) {
            background: #1a3784;
            animation-delay: -1s;
        }

        .load :last-child {
            background: #122752;
        }

        @keyframes spin {
            0%,
            100% {
                transform: translate(0);
            }
            25% {
                transform: translate(160%);
            }
            50% {
                transform: translate(160%, 160%);
            }
            75% {
                transform: translate(0, 160%);
            }
        }
    </style>
    @stack('styles')

{{--    <script src='https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit' async defer></script>--}}
</head>
<body class="use-nicescroll" data-spy="scroll" data-target="#toc">
<div class="images-preloader">
    <div class="load">
        <hr>
        <hr>
        <hr>
        <hr>
    </div>
</div>

<div class="wrapper">
    <div class="main-content scroll-none home-page">
        <header class="site-header header-education dropdown-green">
{{--            <div class="sub-bar">--}}
{{--                <div class="container">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-6 col-sm-6">--}}
{{--                            <div class="contacts">--}}
{{--                                <p><a href="tel:+6281252658218"><i class="fa fa-phone"></i><b>Telepon:</b> +62--}}
{{--                                        812-5265-8218</a></p>--}}
{{--                                <p><a href="mailto:{{env('MAIL_USERNAME')}}"><i--}}
{{--                                            class="fa fa-envelope"></i><b>Email:</b> {{env('MAIL_USERNAME')}}</a></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-sm-6">--}}
{{--                            <div class="social-media">--}}
{{--                                <a href="https://fb.com/ramadhanwahyu.gonzales" target="_blank">--}}
{{--                                    <i class="fab fa-facebook-f"></i></a>--}}
{{--                                <a href="https://twitter.com/ramadhanwahyuu5" target="_blank">--}}
{{--                                    <i class="fab fa-twitter"></i></a>--}}
{{--                                <a href="https://github.com/Ramadhan1101" target="_blank">--}}
{{--                                    <i class="fab fa-github"></i></a>--}}
{{--                                <a href="https://instagram.com/Ramadhan_Wahyu_11" target="_blank">--}}
{{--                                    <i class="fab fa-instagram"></i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="main-bar" id="main-bar">
                <div class="container">
                    <div class="logo">
                        <a href="{{route('beranda')}}">
                            <img width="200" src="{{asset('images/logo/undagi_logo.png')}}" alt="Logo">
                        </a>
                    </div>
                    <button class="btn-toggle"><i class="fa fa-bars"></i></button>
                    <nav class="nav">
                        @include('layouts.partials._headerMenu')
                    </nav>
                </div>
            </div>
        </header>

        @yield('content')
    </div>
</div>

@include('layouts.partials._signUpIn')

<a href="#" onclick="scrollToTop()" class="to-top" title="Go to top">Top</a>
<div class="myProgress">
    <div class="bar"></div>
</div>

<!-- Jquery -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('js/classie.js')}}"></script>
<!-- Core Style -->
<script type="text/javascript" src="{{asset('js/jquery.colorbox.js')}}"></script>
<!-- Carousel Slider  -->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<!-- Jquery Waypoints -->
<script type="text/javascript" src="{{asset('js/waypoints.min.js')}}"></script>
<!-- Jquery Counter -->
<script type="text/javascript" src="{{asset('js/visible.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.easing.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.counterup.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.isotope.min.js')}}"></script>
<!-- Jquery progress bar js-->
<script type="text/javascript" src="{{asset('js/pro-bars.js')}}"></script>
<!-- SLIDER REVOLUTION SCRIPTS  -->
<script type="text/javascript" src="{{asset('vendor/rs-plugin/js/jquery.themepunch.plugins.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
<!-- Template core js -->
<script type="text/javascript" src="{{asset('js/custom-index.js')}}"></script>
<script type="text/javascript" src="{{asset('js/wmbox.js')}}"></script>
<script type="text/javascript" src="{{asset('js/header-fixed.js')}}"></script>

<!-- modal -->
<script src="{{asset('js/modal.js')}}"></script>
<!-- toggle password -->
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<!-- jquery-maskMoney -->
<script src="{{asset('js/jquery.maskMoney.js')}}"></script>
<!-- select2 -->
<script src="{{asset('vendor/select2/dist/js/select2.full.min.js')}}"></script>
<!-- check-mobile -->
<script src="{{asset('vendor/checkMobileDevice.js')}}"></script>
<!-- Nicescroll -->
<script src="{{asset('vendor/nicescroll/jquery.nicescroll.js')}}"></script>
<!-- smooth-scrollbar -->
<script src="{{asset('vendor/smooth-scrollbar/smooth-scrollbar.js')}}"></script>
<!-- Sweetalert2 -->
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
@stack('scripts')
@include('layouts.partials._scripts')
@include('layouts.partials._alert')
@include('layouts.partials._confirm')
</body>
</html>
