@php $kategori = \App\Model\Kategori::orderBy('nama')->get(); @endphp
<ul class="main-menu">
    <li><a class="{{\Illuminate\Support\Facades\Request::is('/*') ? 'active' : ''}}" href="{{route('beranda')}}">
            <i class="fa mr-2"></i>Beranda</a></li>
{{--    <i class="fa fa-home mr-2"></i>Beranda</a></li>--}}
    @auth
        <li class="menu-item-has-children avatar">
            <a href="javascript:void(0)">
{{--                <img class="img-thumbnail show_ava" src="{{Auth::user()->get_bio->foto != "" ?--}}
{{--                asset('storage/users/foto/'.Auth::user()->get_bio->foto) :--}}
{{--                asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}">--}}
                <img class="img-thumbnail show_ava" src="{{Auth::user()->get_bio->foto != "" ?
                asset('storage/users/foto/'.Auth::user()->get_bio->foto) :
                asset('images/faces/thumbs50x50/changwook2.jpg')}}">
                <span class="show_username" style="text-transform: none;color: #2979ff">{{Auth::user()->username}}&nbsp;</span> <i
                    class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu dropdown-arrow">
                @if(Auth::user()->isRoot() || Auth::user()->isAdmin())
                    <li><a href="{{route('admin.dashboard')}}"><i class="fa mr-2"></i>Dashboard</a>
                    </li>
                @else
                    <li><a href="{{route('admin.dashboard')}}"><i class="fa mr-2"></i>Dashboard</a>
                    </li>
                @endif
                <li><a href="{{Auth::user()->isRoot() || Auth::user()->isAdmin() ? route('admin.edit.profile') :
                route('user.profil')}}">Sunting Profil</a></li>
{{--                <li><a href="{{Auth::user()->isRoot() || Auth::user()->isAdmin() ? route('admin.settings') :--}}
{{--                route('user.pengaturan')}}"><i class="fa fa-cogs mr-2"></i>Pengaturan Akun</a></li>--}}
                <li>
                    <a href="#" class="btn_signOut">Keluar&nbsp;<i class="fa fa-sign-out-alt"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    @else
        <li><a href="javascript:void(0)" data-toggle="modal" onclick="openLoginModal();">Masuk</a></li>
        <li>
            <div class="get-btn">
                <a href="javascript:void(0)" data-toggle="modal" onclick="openRegisterModal();">Daftar</a>
            </div>
        </li>
    @endif
</ul>
