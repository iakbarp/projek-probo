<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap/css/glyphicons.css')}}">
    <!-- Page Specific CSS File -->
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/izitoast/css/iziToast.min.css')}}">
@stack('styles')

<!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('admins/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/components.css')}}">

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>
<body class="use-nicescroll">
@php $role = Auth::user(); @endphp
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
{{--            <ul class="navbar-nav mr-auto">--}}
{{--                <li><a href="javascript:void(0)" data-toggle="sidebar" class="nav-link nav-link-lg">--}}
{{--                        <i class="fas fa-bars"></i></a></li>--}}
{{--            </ul>--}}
            <ul class="navbar-nav mr-auto">
                <li>
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a style="background-color: #122752" href="{{route('beranda')}}" class="btn btn-lg btn-block ">
                            <span style="color: white"> <i class="fas fa-paper-plane"> </i> GO TO MAIN SITE</span></a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav navbar-right">
{{--                <li class="dropdown dropdown-list-toggle">--}}
{{--                    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">--}}
{{--                        <i class="far fa-bell"></i></a>--}}
{{--                    <div class="dropdown-menu dropdown-list dropdown-menu-right">--}}
{{--                        <div class="dropdown-header">Notifications--}}
{{--                            <div class="float-right">--}}
{{--                                <a href="#">Mark All As Read</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="dropdown-list-content dropdown-list-icons">--}}
{{--                            <a href="#" class="dropdown-item dropdown-item-unread">--}}
{{--                                <div class="dropdown-item-icon bg-primary text-white">--}}
{{--                                    <i class="fas fa-code"></i>--}}
{{--                                </div>--}}
{{--                                <div class="dropdown-item-desc">--}}
{{--                                    Template update is available now!--}}
{{--                                    <div class="time text-primary">2 Min Ago</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="dropdown-item">--}}
{{--                                <div class="dropdown-item-icon bg-info text-white">--}}
{{--                                    <i class="far fa-user"></i>--}}
{{--                                </div>--}}
{{--                                <div class="dropdown-item-desc">--}}
{{--                                    <b>You</b> and <b>Dedik Sugiharto</b> are now friends--}}
{{--                                    <div class="time">10 Hours Ago</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="dropdown-item">--}}
{{--                                <div class="dropdown-item-icon bg-success text-white">--}}
{{--                                    <i class="fas fa-check"></i>--}}
{{--                                </div>--}}
{{--                                <div class="dropdown-item-desc">--}}
{{--                                    <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>--}}
{{--                                    <div class="time">12 Hours Ago</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="dropdown-item">--}}
{{--                                <div class="dropdown-item-icon bg-danger text-white">--}}
{{--                                    <i class="fas fa-exclamation-triangle"></i>--}}
{{--                                </div>--}}
{{--                                <div class="dropdown-item-desc">--}}
{{--                                    Low disk space. Let's clean it!--}}
{{--                                    <div class="time">17 Hours Ago</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="dropdown-item">--}}
{{--                                <div class="dropdown-item-icon bg-info text-white">--}}
{{--                                    <i class="fas fa-bell"></i>--}}
{{--                                </div>--}}
{{--                                <div class="dropdown-item-desc">--}}
{{--                                    Welcome to Stisla template!--}}
{{--                                    <div class="time">Yesterday</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="dropdown-footer text-center">--}}
{{--                            <a href="#">View All <i class="fas fa-chevron-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </li>--}}

                <li class="dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown"
                       class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{$role->get_bio->foto != "" ? asset('storage/users/foto/'.$role->get_bio->foto) :
                        asset('admins/img/avatar/8.png')}}">
{{--                        asset('admins/img/avatar/avatar-'.rand(1,6).'.png')}}" class="rounded-circle mr-1">--}}
                        <div class="d-sm-none d-lg-inline-block">{{$role->name}}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('admin.settings')}}" class="dropdown-item has-icon"> Sunting Profil <i class="fas fa-cogs"></i></a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item has-icon text-danger btn_signOut">
                            <i class="fas fa-sign-out-alt"></i> Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">{{csrf_field()}}
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
{{--                    <a href="{{route('admin.dashboard')}}">Admin {{env('APP_NAME')}}</a>--}}
                    <a href="{{route('admin.dashboard')}}"><img src="{{asset('images/logo/undagi_logo.png')}}" alt="" height="50" width="175"></a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{route('admin.dashboard')}}">
                        <img class="img-fluid" width="75%" src="{{asset('images/logo/icon.png')}}">
                    </a>
                </div>
                @include('layouts.partials._sidebarMenu')
            </aside>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
            <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Negara</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit" action="{{route('admin.show.negara.update')}}" method="post">
                                @CSRF
                                <div class="form-group">
                                    <label>ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="id" id="key" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Negara</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_negara()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="updateProvinsiModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Provinsi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-prov" action="{{route('admin.show.provinsi.update')}}" method="post">
                                @CSRF
                                <div class="form-group">
                                    <label>ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="id" id="keyprov" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Negara</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Suabaya " name="name"
                                               id="nameprov" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_provinsi()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="updateKategori" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-kategori" action="{{route('admin.show.kategori.update')}}"
                                  method="post">
                                @CSRF
                                <div class="form-group">
                                    <label>ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="id" id="key_kategori" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name_kategori" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_kategori()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="updateSubKategori" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Sub Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-subkategori" action="{{route('admin.show.subkategori.update')}}"
                                  method="post">
                                @CSRF
                                <div class="form-group">
                                    <label>ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="id" id="key_subkategori" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Sub Kategori</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name_subkategori" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_subkategori()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalProsesProject" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Proses Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-payment" action="{{route('admin.project.done')}}"
                                  method="post">
                                @CSRF
                                <div class="row">
                                    <div class="form-group col-md-8 col-12">
                                        <label>Nomor Rekening</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-credit-card"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="rekening" id="rekening" required readonly>
                                            <input type="hidden" name="id" id="id_payment">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Bank</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="an" id="bank" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>Atas Nama (A.n)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia " name="name"
                                                   id="an" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>Biaya  Project</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="rekening" id="harga" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="payment()">Proses Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalProsesService" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Proses Pembayaran Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-service" action="{{route('admin.service.done')}}"
                                  method="post">
                                @CSRF
                                <div class="row">
                                    <div class="form-group col-md-8 col-12">
                                        <label>Nomor Rekening</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-credit-card"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="rekening" id="rekening_service" required readonly>
                                            <input type="hidden" name="id" id="id_service">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Bank</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="an" id="bank_service" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>Atas Nama (A.n)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia " name="name"
                                                   id="an_service" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>Biaya  Project</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="rekening" id="harga_service" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="service()">Proses Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                © {{now()->format('Y').' '.env('APP_NAME')}}. All rights reserved.
            </div>
            <div class="footer-right">
                {{--Designed & Developed by <a href="http://rabbit-media.net" target="_blank">Rabbit Media</a>--}}
            </div>
        </footer>
    </div>
</div>
<div class="progress">
    <div class="bar"></div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('admins/modules/jquery.min.js')}}"></script>
<script src="{{asset('admins/modules/popper.js')}}"></script>
<script src="{{asset('admins/modules/tooltip.js')}}"></script>
<script src="{{asset('admins/modules/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/nicescroll/jquery.nicescroll.js')}}"></script>
<script src="{{asset('admins/modules/moment.min.js')}}"></script>
<script src="{{asset('admins/js/stisla.js')}}"></script>
<script src="{{asset('vendor/hideShowPassword.min.js')}}"></script>

<!-- Page Specific JS File -->
<script src="{{asset('admins/modules/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('admins/modules/izitoast/js/iziToast.min.js')}}"></script>
<script src="{{asset('vendor/checkMobileDevice.js')}}"></script>
<script src="{{asset('admins/modules/jquery.form.min.js')}}"></script>
@stack('scripts')

<!-- Template JS File -->
<script src="{{asset('admins/js/main.js')}}"></script>
<script src="{{asset('admins/js/custom.js')}}"></script>
<script>
    @if(session('signed'))
    swal('Telah Masuk!', 'Halo {{$role->name}}! Anda telah masuk.', 'success');

    @endif

    function numberOnly(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else return true;
        keychar = String.fromCharCode(key);
        if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27) || (key == 188)) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else return false;
    }

    $(document).on('mouseover', '.use-nicescroll', function () {
        $(this).getNiceScroll().resize();
    });
</script>
@include('layouts.partials._confirm')
@include('layouts.partials._toastnotify')
</body>
</html>
