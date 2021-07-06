<ul class="sidebar-menu">
    @if(Auth::user()->isRoot() || Auth::user()->isAdmin())
        <li class="menu-header">General</li>
        <li class="dropdown {{\Illuminate\Support\Facades\Request::is('sys-admin/dashboard*') ? 'active' : ''}}">
            <a href="{{route('admin.dashboard')}}" class="nav-link">
                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
        </li>

        {{--    <li class="menu-header">Data Pembayaran</li>--}}
        {{--    <li class="dropdown">--}}
        {{--        <a href="javascript:void(0)" class="nav-link has-dropdown remove-caret" data-toggle="dropdown">--}}
        {{--            <i class="fas fa-credit-card"></i><span>Jenis Pembayaran</span></a>--}}
        {{--        <ul class="dropdown-menu">--}}
        {{--            <li class=""><a href="{{route('admin.project.show')}}" class="nav-link">Proyek</a></li>--}}
        {{--            <li class=""><a href="{{route('admin.service.show')}}" class="nav-link">Layanan</a></li>--}}
        {{--            <li class=""><a href="{{route('admin.withdraw.show')}}" class="nav-link">Withdraw</a></li>--}}
        {{--        </ul>--}}
        {{--    </li>--}}

        <li class="menu-header">Data Master</li>

        <li class="dropdown">
            <a href="javascript:void(0)" class="nav-link has-dropdown remove-caret" data-toggle="dropdown">
                <i class="fas fa-briefcase"></i><span>Data Master</span></a>
            <ul class="dropdown-menu">
                <li class=""><a href="{{route('admin.show.status_dokumen')}}" class="nav-link">Status Dokumen</a></li>
                <li class=""><a href="{{route('admin.show.pernikahan')}}" class="nav-link">Menikah</a></li>
                <li class=""><a href="{{route('admin.show.kematian')}}" class="nav-link">Meninggal</a></li>
                <li class=""><a href="{{route('admin.show.kelahiran')}}" class="nav-link">Kelahiran</a></li>
                <li class=""><a href="{{route('admin.show.perubahan')}}" class="nav-link">Status</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="javascript:void(0)" class="nav-link has-dropdown remove-caret" data-toggle="dropdown">
                <i class="fas fa-user"></i><span>Akun</span></a>
            <ul class="dropdown-menu">
                <li class=""><a href="{{route('admin.show.admin')}}" class="nav-link">Admin</a></li>
                <li class=""><a href="{{route('admin.settings')}}" class="nav-link">Pengaturan</a></li>
            </ul>
        </li>

        {{--    <li class="dropdown">--}}
        {{--        <a href="javascript:void(0)" class="nav-link has-dropdown remove-caret" data-toggle="dropdown">--}}
        {{--            <i class="fas fa-map-marker-alt"></i><span>Lokasi</span></a>--}}
        {{--        <ul class="dropdown-menu">--}}
        {{--            <li class=""><a href="{{route('admin.show.negara')}}" class="nav-link">Negara & Provinsi</a></li>--}}
        {{--        </ul>--}}
        {{--    </li>--}}

        <li class="dropdown">
            <a href="javascript:void(0)" class="nav-link has-dropdown remove-caret" data-toggle="dropdown">
                <i class="fas fa-tasks"></i><span>Master Kategori</span></a>
            <ul class="dropdown-menu">
                <li class=""><a href="{{route('admin.show.kategori')}}" class="nav-link">Kategori & Sub-kategori</a></li>
            </ul>
        </li>
    @else
        <li class="menu-header">General</li>
{{--        <li class="dropdown">--}}
{{--            <a href="{{route('admin.show.status_dokumen')}}" class="nav-link">--}}
{{--                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>--}}
{{--            </a>--}}
{{--        </li>--}}
@endif
</ul>

{{--<div class="mt-4 mb-4 p-3 hide-sidebar-mini">--}}
{{--    <a href="{{route('beranda')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">--}}
{{--        <i class="fas fa-rocket"></i> GO TO MAIN SITE</a>--}}
{{--</div>--}}
