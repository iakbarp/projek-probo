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
                        <a style="background-color: #122752" href="{{route('admin.dashboard')}}" class="btn btn-lg btn-block ">
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
{{--            Dokumen--}}
            <div class="modal fade" tabindex="-1" role="dialog" id="updateDokumenModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Dokumen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-dokumen" action="{{route('admin.show.status_dokumen.update')}}" method="post">
                                @CSRF
                                <div class="input-group">
                                    <input type="hidden" class="form-control disabled" placeholder="indonesia "
                                           name="id" id="keyid">
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="NIK"
                                               name="nik" id="key_dokumen" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name_dokumen" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <select name="kategori_id"
                                                      class="form-control use-select2" required>
                                        <option disabled selected id="kategori_id_edit">Pilih Kategori</option>
                                            <option value="1">Menikah</option>
                                            <option value="2">Kelahiran</option>
                                            <option value="3">Meninggal</option>
                                            <option value="4">Status</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>R2</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="R2 " name="r2"
                                               id="r2_edit" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-money-bill-wave-alt"></i>
                                            </div>
                                        </div>
                                        <input id="nominal_edit" class="form-control"
                                               name="nominal"
                                               type="text" placeholder="Rp. "
                                               onkeypress="return numberOnly(event, false)"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Terbilang</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input style="text-transform:uppercase" type="text" class="form-control" placeholder="Terbilang " name="terbilang"
                                               id="terbilang_edit" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Keterangan " name="keterangan"
                                               id="keterangan_edit" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Berkas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="file" class="form-control" placeholder="indonesia " name="berkas"
                                               id="berkas_edit" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kelengkapan Berkas</label>
                                    <div class="input-group">
{{--                                    <div class="custom-checkbox custom-control">--}}
{{--                                        <input id="cb-selesai" type="checkbox"--}}
{{--                                               class="custom-control-input"--}}
{{--                                               name="selesai" value="1">--}}
{{--                                        <label for="cb-selesai" class="custom-control-label"--}}
{{--                                               style="text-transform: none;">Berkas Lengkap ?--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                    </div>
                                        <select name="selesai"
                                                class="form-control use-select2" required>
                                            <option disabled selected id="selesai_id_edit">Pilih</option>
                                            <option value="1">Belum</option>
                                            <option value="2">Sudah</option>
                                        </select>
                                </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_dokumen()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="lihatKematian" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Data Kematian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-lihat-kematian">
                                @CSRF
                                <div class="form-group">
                                    <label>NIK</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="nik" id="key_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dept</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Department " name="dept"
                                               id="dept_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Group</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Group" id="group_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Orang Meninggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user-times"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nama Orang Meninggal" name="meninggal" id="meninggal_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Meninggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Departement" name="status_meninggal" id="status_meninggal_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Uang Santunan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-money-bill-wave-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Departement" name="uang_duka" id="uang_duka_lihat" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

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

{{--            Status Dokumen--}}
            <div class="modal fade" tabindex="-1" role="dialog" id="lihatKematian" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Data Kematian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-lihat-kematian">
                                @CSRF
                                <div class="form-group">
                                    <label>NIK</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="nik" id="key_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dept</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Department " name="dept"
                                               id="dept_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Group</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Group" id="group_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Orang Meninggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user-times"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nama Orang Meninggal" name="meninggal" id="meninggal_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Meninggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Departement" name="status_meninggal" id="status_meninggal_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Uang Santunan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-money-bill-wave-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Departement" name="uang_duka" id="uang_duka_lihat" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="updateKematianModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Meninggal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-kematian" action="{{route('admin.show.kematian.update')}}" method="post">
                                @CSRF
                                <div class="input-group">
                                    <input type="hidden" class="form-control disabled" placeholder="indonesia "
                                           name="id" id="key_id">
                                </div>
                                <div class="form-group">
                                    <label>PT</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <select  name="pt"
                                                class="form-control use-select2">
                                            <option id="pt_edit" disabled selected>Pilih Group</option>
                                            <option value="PT. Ajinomoto">PT. Ajinomoto</option>
                                            <option value="PT. Ajinex">PT. Ajinex</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dept.</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Dept " name="dept"
                                               id="dept_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div class="input-group">
                                        <select name="bank_id"
                                                class="form-control selectpicker use-select2" data-live-search="true">
                                            <option id="bank_id_edit" disabled selected>Pilih Bank</option>
                                            @foreach(\App\Model\Bank::all() as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user-times"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nomor Rekening" name="rekening" id="rekening_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Yang Meninggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user-times"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Yang Meninggal" name="status_meninggal" id="status_meninggal_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Meninggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" type="date" id="tanggal_meninggal_edit" name="tanggal_meninggal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <div class="input-group">
                                        <select name="kota_id"
                                                class="form-control selectpicker use-select2" data-live-search="true">
                                            <option id="kota_id_edit" disabled selected>Pilih Kota</option>
                                            @foreach(\App\Model\Kota::all() as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Alm.</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nama Almarhum " name="meninggal"
                                               id="meninggal_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alm.</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <select name="alm"
                                                class="form-control use-select2">
                                            <option id="alm_edit" disabled selected>Pilih Alm</option>
                                            <option value="Almarhum">Almarhum</option>
                                            <option value="Almarhumah">Almarhumah</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_kematian()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

{{--            edit menikah--}}
            <div class="modal fade" tabindex="-1" role="dialog" id="updatePernikahanModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Menikah</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-pernikahan" action="{{route('admin.show.pernikahan.update')}}" method="post">
                                @CSRF
                                <div class="input-group">
                                    <input type="hidden" class="form-control disabled" placeholder="indonesia "
                                           name="id" id="key_idpernikahan">
                                </div>
                                <div class="form-group">
                                    <label>PT</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <select  name="pt"
                                                 class="form-control use-select2">
                                            <option id="pt_pernikahan" disabled selected>Pilih Group</option>
                                            <option value="PT. Ajinomoto">PT. Ajinomoto</option>
                                            <option value="PT. Ajinex">PT. Ajinex</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dept.</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Dept " name="dept"
                                               id="dept_pernikahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div class="input-group">
                                        <select name="bank_id" class="form-control selectpicker use-select2" data-live-search="true">
                                            <option id="bank_id_pernikahan" disabled selected>Pilih Bank</option>
                                            @foreach(\App\Model\Bank::all() as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user-times"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nomor Rekening" name="rekening" id="rekening_pernikahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kota Menikah</label>
                                    <div class="input-group">
                                        <select name="kota_id"
                                                class="form-control selectpicker use-select2" data-live-search="true">
                                            <option id="kota_id_pernikahan" disabled selected>Pilih Kota</option>
                                            @foreach(\App\Model\Kota::all() as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Menikah</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" type="date" id="tanggal_pernikahan_edit" name="tanggal_menikah">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Istri</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nama Istri " name="nama_istri"
                                               id="nama_istri_edit">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_pernikahan()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

{{--            edit kelahiran--}}
            <div class="modal fade" tabindex="-1" role="dialog" id="updateKelahiranModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Kelahiran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-kelahiran" action="{{route('admin.show.kelahiran.update')}}" method="post">
                                @CSRF
                                <div class="input-group">
                                    <input type="hidden" class="form-control disabled" placeholder="indonesia "
                                           name="id" id="key_id_kelahiran">
                                </div>
                                <div class="form-group">
                                    <label>PT</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <select  name="pt"
                                                 class="form-control use-select2">
                                            <option id="pt_edit_kelahiran" disabled selected>Pilih Group</option>
                                            <option value="PT. Ajinomoto">PT. Ajinomoto</option>
                                            <option value="PT. Ajinex">PT. Ajinex</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dept.</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Dept " name="dept"
                                               id="dept_edit_kelahiran">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div class="input-group">
                                        <select name="bank_id" class="form-control selectpicker use-select2" data-live-search="true">
                                            <option id="bank_id_edit_kelahiran" disabled selected>Pilih Bank</option>
                                            @foreach(\App\Model\Bank::all() as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user-times"></i>
                                            </div>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Nomor Rekening" name="rekening"
                                               id="rekening_edit_kelahiran">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kota Menikah</label>
                                    <div class="input-group">
                                        <select name="kota_id"
                                                class="form-control selectpicker use-select2" data-live-search="true">
                                            <option id="kota_id_edit_kelahiran" disabled selected>Pilih Kota</option>
                                            @foreach(\App\Model\Kota::all() as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Putra/Putri</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Putra/Putri ke- " name="putra"
                                               id="putra_edit_kelahiran">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" type="date" id="tanggal_kelahiran_edit" name="tanggal_lahir">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Anak</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nama Anak " name="nama_anak"
                                               id="nama_anak_edit">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_kelahiran()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

{{--            edit perubahan--}}
            <div class="modal fade" tabindex="-1" role="dialog" id="updatePerubahanModal" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunting Data Perubahan Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-edit-perubahan" action="{{route('admin.show.perubahan.update')}}" method="post">
                                @CSRF
                                <div class="input-group">
                                    <input type="hidden" class="form-control disabled" placeholder="indonesia "
                                           name="id" id="key_id_perubahan">
                                </div>
                                <div class="form-group">
                                    <label>Perubahan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Jenis Perubahan " name="perubahan"
                                               id="perubahan_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dari Sebelumnya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-undo"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Sebelumnya " name="sebelum"
                                               id="sebelum_perubahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Menjadi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-redo"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Menjadi " name="sesudah"
                                               id="sesudah_perubahan">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_perubahan()">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="lihatKematian" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Data Kematian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-lihat-kematian">
                                @CSRF
                                <div class="form-group">
                                    <label>NIK</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control disabled" placeholder="indonesia "
                                               name="nik" id="key_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="indonesia " name="name"
                                               id="name_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dept</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Department " name="dept"
                                               id="dept_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Group</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Group" id="group_lihat" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Orang Meninggal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-user-times"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nama Orang Meninggal" name="meninggal" id="meninggal_lihat" disabled>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Meninggal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Departement" name="status_meninggal" id="status_meninggal_lihat" disabled>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Uang Santunan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-money-bill-wave-alt"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Departement" name="uang_duka" id="uang_duka_lihat" disabled>
                                </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                            <input type="number" class="form-control disabled" placeholder="indonesia "
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
                                                   name="an" id="bank_id" required readonly>
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

{{--            Withdraw --}}
            <div class="modal fade" tabindex="-1" role="dialog" id="modalProsesWithdraw" style="z-index: 99999">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Proses Pembayaran Withdraw</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-withdraw" action="{{route('admin.withdraw.done')}}"
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
                                                   name="rekening" id="rekening_withdraw" required readonly>
                                            <input type="hidden" name="id" id="id_withdraw">
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
                                                   name="an" id="bank_withdraw" required readonly>
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
                                                   id="an_withdraw" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>Jumlah Withdraws</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" placeholder="indonesia "
                                                   name="jumlah" id="jumlah" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="withdraw()">Proses Pembayaran
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
