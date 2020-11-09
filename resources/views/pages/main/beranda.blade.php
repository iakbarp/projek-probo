@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.min.css')}}">
    <style>
        .form-control-2[disabled] {
            cursor: not-allowed;
            background-color: #eee;
            opacity: 1
        }

        ul.ui-autocomplete {
            color: #122752;
            border-radius: 0 0 1rem 1rem;
        }

        ul.ui-autocomplete .ui-menu-item .ui-state-active,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:focus {
            background: #122752;
            color: #fff;
            border: 1px solid #122752;
        }

        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:focus {
            border-radius: 0 0 1rem 1rem;
        }

        .projects-4 {
            margin: 0 auto;
        }

        .projects-4:after {
            content: '';
            display: block;
            clear: both;
        }

        .projects-4 .item {
            margin-bottom: 20px;
        }

        .rating {
            border: none;
            float: left;
        }

        .rating > input {
            display: none;
        }

        .rating > label:before {
            margin: 0 5px 0 5px;
            font-size: 1.25em;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            content: "\f089";
            position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        .rating > input:checked ~ label,
        .rating:not(:checked) > label:hover,
        .rating:not(:checked) > label:hover ~ label {
            color: #ffc100;
        }

        .rating > input:checked + label:hover,
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label,
        .rating > input:checked ~ label:hover ~ label {
            color: #e1a500;
        }
    </style>
@endpush
@section('content')
    <!-- slider -->
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-6">
                            <br><br>
                            <br><br>
                            <div class="tp-caption sfr stb text-justify custom-size-7 strong-black tp-resizeme zindex">
                                Temukan
                            </div>
                            <div class="tp-caption sfr stb text-justify custom-size-7 strong-black tp-resizeme zindex">
                                Pekerja Terbaik
                            </div>
                            <div class="tp-caption sfr stb text-justify custom-size-7 strong-black tp-resizeme zindex">
                                Di UNDAGI
                            </div>
                            <div class="text-justify custom-size-8 strong-black">
                                 Undagi membantu anda menemukan pekerja terbaik, proyek, maupun layanan sesuai dengan kebutuhan anda!
                            </div>
                            <br><br>
                                <form id="form-pencarian" class="search-category" action="{{route('cari.data')}}">
                                    <div class="input-group">
                                        <div class="search-panel">
                                        <div id="filter-pencarian" role="menu">
                                            <button class="btn-search" data-filter="pekerja"><a href="#"><small style="color: white">Pekerja</small></a></button>
                                            <button class="btn-search" style="background-color: transparent" data-filter="proyek"><a href="#"><small style="color: black">Proyek</small></a></button>
                                            <button class="btn-search" style="background-color: transparent" data-filter="layanan"><a href="#"> <small style="color: black">Layanan</small></a> </button>
                                        </div>
                                        </div>
                                        <div style="background-color: #2979FF;padding: 17px 30px;border: none">
                                            <input style="padding: 12px;width: 117px;display: inline-block;border-radius: 4px;border: none" type="text" placeholder="keyword"
                                                   autocomplete="off" id="keyword" name="q">
                                            <input type="hidden" name="filter">
                                            <select class="selectpicker" style="display: inline-block;border: none;padding: 15px;width: 117px;border-radius: 4px">
                                                <option>Kategori</option>
                                            </select>
                                            <select style="padding: 15px;width: 117px;border-radius: 4px;border: none" class="selectpicker">
                                                <option>Sub Kategori</option>
                                            </select>
                                            <button style="background-color: #0d47a1;padding: 15px;width: 117px;border-radius: 4px;border: none"><small style="color: white">CARI</small> </button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        <div class="col-md-6">
                            <img src="{{asset('images/slider/slider_undagi.jpg')}}">
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <br><br>--}}
{{--                            <br><br>--}}
{{--                            <br><br>--}}
{{--                            <div class="course-search">--}}
{{--                                    <form id="form-pencarian" class="search-category" action="{{route('cari.data')}}">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <div class="input-group-btn search-panel">--}}
{{--                                                <button type="button" class="btn-course border-radius-2 dropdown-toggle"--}}
{{--                                                        data-toggle="dropdown" style="border-radius: 20px 0 0 20px; margin-right: -2px">--}}
{{--                                                    <span id="txt_filter">FILTER</span> <span class="caret"></span></button>--}}
{{--                                                <ul id="filter-pencarian" class="dropdown-Menu" role="menu">--}}
{{--                                                    <li data-filter="proyek"><a href="#">PROYEK</a></li>--}}
{{--                                                    <li data-filter="layanan"><a href="#">LAYANAN</a></li>--}}
{{--                                                    <li data-filter="pekerja"><a href="#">PEKERJA</a></li>--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                            <input id="keyword" type="text" class="form-control-2 padd-size size-2" name="q"--}}
{{--                                                   placeholder="Cari&hellip;" autocomplete="off" disabled style="border-radius: 0">--}}
{{--                                            <input type="hidden" name="filter">--}}
{{--                                            <span class="input-group-btn">--}}
{{--                        <button class="btn-course" type="reset" id="btn_reset" style="display: none">--}}
{{--                            <i class="fa fa-times"></i></button>--}}
{{--                        <button class="btn-course border-radius-2" type="submit">CARI</button>--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
            </div>
        </div>
    </div>
{{--    <section class="home-slider">--}}
{{--        <div id="slider">--}}
{{--            <div class="fullwidthbanner-container">--}}
{{--                <div id="revolution-slider">--}}
{{--                    <ul>--}}
{{--                        <li class="slider-bg2" data-transition="fade" data-slotamount="7" data-masterspeed="500">--}}
{{--                            <img src="{{asset('images/slider/slider_undagi.jpg')}}" alt="">--}}
{{--                            <div class="tp-caption sfr stb text-justify custom-size-7 strong-black tp-resizeme zindex"--}}
{{--                                 data-x="center"--}}
{{--                                 data-hoffset="-15"--}}
{{--                                 data-y="150"--}}
{{--                                 data-speed="300"--}}
{{--                                 data-start="1300"--}}
{{--                                 data-easing="easeInOut">--}}
{{--                                TEMUKAN PEKERJA TERBAIK DI UNDAGI--}}
{{--                            </div>--}}
{{--                            <div class="tp-caption sfr stb text-justify custom-size-8 strong-black tp-resizeme zindex"--}}
{{--                                 data-x="center"--}}
{{--                                 data-hoffset="-15"--}}
{{--                                 data-y="230"--}}
{{--                                 data-speed="300"--}}
{{--                                 data-start="1300"--}}
{{--                                 data-easing="easeInOut">--}}
{{--                                <p>Dapatkan layanan terbaik untuk memenuhi kebutuhan tugas/proyek Anda<br>--}}
{{--                                    yang disediakan oleh <b>Pekerja</b> {{env('APP_NAME')}}.</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}

{{--                        <li class="slider-bg2" data-transition="fade" data-slotamount="7" data-masterspeed="500">--}}
{{--                            <img src="{{asset('images/slider/beranda-proyek.jpg')}}" alt="">--}}
{{--                            <div class="tp-caption sfr stt custom-size-6 strong-black tp-resizeme zindex"--}}
{{--                                 data-x="center"--}}
{{--                                 data-hoffset="-15"--}}
{{--                                 data-y="150"--}}
{{--                                 data-speed="300"--}}
{{--                                 data-start="1000"--}}
{{--                                 data-easing="easeInOut">--}}
{{--                                TEMUKAN PROYEK TERBARU--}}
{{--                            </div>--}}
{{--                            <div class="tp-caption sfr stb text-center custom-size-8 strong-black tp-resizeme zindex"--}}
{{--                                 data-x="center"--}}
{{--                                 data-hoffset="-15"--}}
{{--                                 data-y="230"--}}
{{--                                 data-speed="300"--}}
{{--                                 data-start="1800"--}}
{{--                                 data-easing="easeInOut">--}}
{{--                                <p>Dapatkan proyek terbaru dari berbagai kategori pekerjaan<br>--}}
{{--                                    yang dibagikan oleh <b>Klien</b> {{env('APP_NAME')}}.</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <!-- form pencarian -->
{{--    <div class="course-search">--}}
{{--        <div class="search-center">--}}
{{--            <form id="form-pencarian" class="search-category" action="{{route('cari.data')}}">--}}
{{--                <div class="input-group">--}}

{{--                    <div class="input-group-btn search-panel">--}}
{{--                        <button type="button" class="btn-course border-radius-2 dropdown-toggle"--}}
{{--                                data-toggle="dropdown" style="border-radius: 20px 0 0 20px; margin-right: -2px">--}}
{{--                            <span id="txt_filter">FILTER</span> <span class="caret"></span></button>--}}
{{--                        <ul id="filter-pencarian" class="dropdown-Menu" role="menu">--}}
{{--                            <li data-filter="proyek"><a href="#">TUGAS/PROYEK</a></li>--}}
{{--                            <li data-filter="layanan"><a href="#">LAYANAN</a></li>--}}
{{--                            <li data-filter="pekerja"><a href="#">PEKERJA</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <input id="keyword" type="text" class="form-control-2 padd-size size-2" name="q"--}}
{{--                           placeholder="Cari&hellip;" autocomplete="off" disabled style="border-radius: 0">--}}
{{--                    <input type="hidden" name="filter">--}}
{{--                    <span class="input-group-btn">--}}
{{--                        <button class="btn-course" type="reset" id="btn_reset" style="display: none">--}}
{{--                            <i class="fa fa-times"></i></button>--}}
{{--                        <button class="btn-course border-radius-2" type="submit">--}}
{{--                            <i class="fa fa-search"></i></button>--}}
{{--                            <i class="fa fa-search"> CARI</i></button>--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}

    {{--                    <div class="our-projects color-2 search-panel">--}}
    {{--                        <ul id="filter-pencarian" class="filter-projects none-style" role="menu">--}}
    {{--                            <li><a href="#" class="current" data-filter=".proyek" data-id="proyek" title="">TUGAS/PROYEK</a></li>--}}
    {{--                            <li><a href="#" data-filter=".layanan" data-id="layanan" title="">LAYANAN</a></li>--}}
    {{--                            <li><a href="#" data-filter=".pekerja" data-id="pekerja" title="">PEKERJA TERBAIK</a></li>--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    <!-- fitur -->
{{--    <section class="section-course">--}}
{{--        <div class="container">--}}
{{--            <div class="boxes-center">--}}
{{--                <div class="row">--}}
{{--                    <div class="text-center custom-size-20">PRODUK KAMI</div>--}}
{{--                    <div></div>--}}
{{--                    <div></div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="box-content text-center">--}}
{{--                            <h3><img src="{{asset('images/engineering.png')}}"></h3>--}}
{{--                            <h2>PROYEK</h2>--}}
{{--                            <p align="justify">Temukan layanan apapun dan ketahui persis apa/berapa yang akan Anda--}}
{{--                                bayar. Tidak ada tarif per jam, hanya ada harga tetap.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="box-content text-center">--}}
{{--                            <h3><img src="{{asset('images/engineering.png')}}"></h3>--}}
{{--                            <h2>PEKERJA</h2>--}}
{{--                            --}}{{----}}{{--                            <p align="justify">Temukan layanan apapun dan ketahui persis apa/berapa yang akan Anda--}}
{{--                            --}}{{----}}{{--                                bayar. Tidak ada tarif per jam, hanya ada harga tetap.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="box-content text-center">--}}
{{--                        <h3><img src="{{asset('images/engineering.png')}}"></h3>--}}
{{--                        <h2>PEKERJA</h2>--}}
{{--                        --}}{{----}}{{--                            <p align="justify">Temukan layanan apapun dan ketahui persis apa/berapa yang akan Anda--}}
{{--                        --}}{{----}}{{--                                bayar. Tidak ada tarif per jam, hanya ada harga tetap.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
<br><br>
    <br><br>
    <br><br>
    <br><br>
    <section class="subscribe bg-green">
        <div class="container">
            <div class="boxes-center">
                <div class="row">
                    <div class="text-center custom-size-13">PRODUK KAMI</div>
                    <div class="col-md-4">
                        <div class="box-content text-center">
                            <h2><img src="{{asset('images/engineering.png')}}"></h2>
                            <h3 style="color: white">PROYEK</h3>
                            {{--                            <p align="justify">Temukan layanan apapun dan ketahui persis apa/berapa yang akan Anda--}}
                            {{--                                bayar. Tidak ada tarif per jam, hanya ada harga tetap.</p>--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-content text-center custom-size-13">
                            <h2><img src="{{asset('images/work.png')}}"></h2>
                            <h3 style="color: white">Layanan</h3>
                            {{--                            <p align="justify">Temukan layanan apapun dan ketahui persis apa/berapa yang akan Anda--}}
                            {{--                                bayar. Tidak ada tarif per jam, hanya ada harga tetap.</p>--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-content text-center">
                            <h2><img src="{{asset('images/people.png')}}"></h2>
                            <h3 style="color: white">PEKERJA</h3>
                            {{--                            <p align="justify">Temukan layanan apapun dan ketahui persis apa/berapa yang akan Anda--}}
                            {{--                                bayar. Tidak ada tarif per jam, hanya ada harga tetap.</p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- update terbaru -->
    <section class="text-center our-works2 border-2 light padd-40">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title text-center">Update <strong class="strong-green">Terbaru</strong></h2>
                </div>
            </div>
        </div>
        <div class="our-projects color-2">
            <ul id="filter-daftar" class="filter-projects none-style">
                <li><a href="#" class="current" data-filter=".proyek" data-id="proyek" title=""><i class="fa fa-tasks"></i>&nbsp;PROYEK
                        <span class="badge badge-secondary">{{count($proyek) > 999 ? '999+' : count($proyek)}}</span></a></li>
                <li><a href="#" data-filter=".layanan" data-id="layanan" title=""><i class="fa fa-tools"></i>&nbsp;LAYANAN
                        <span class="badge badge-secondary">{{count($layanan) > 999 ? '999+' : count($layanan)}}</span></a></li>
                <li><a href="#" data-filter=".pekerja" data-id="pekerja" title=""><i class="fa fa-users"></i>&nbsp;PEKERJA TERBAIK
                        <span class="badge badge-secondary">{{count($pekerja) > 999 ? '999+' : count($pekerja)}}</span></a></li>
            </ul>

            <div id="update-terbaru" class="all-projects projects-4">
                <div class="card">
                @foreach($proyek as $row)
                    @php
                        $total_ulasan_klien = \App\Model\Review::whereHas('get_project', function ($q) use ($row) {
                            $q->where('user_id', $row->user_id);
                        })->count();
                        $rate = $total_ulasan_klien > 0 ? $row->get_user->get_bio->total_bintang_klien / $total_ulasan_klien : 0;
                    @endphp
                    <div class="item proyek">
                        <div class="our-courses">
                            <div class="img-wrapper">
                                <a href="{{route('detail.proyek',['username' => $row->get_user->username, 'judul' =>
                                $row->permalink])}}">
                                    <img src="{{$row->thumbnail!="" ? asset('storage/proyek/thumbnail/'.$row->thumbnail)
                                    : asset('images/slider/beranda-'.rand(1,2).'.jpg')}}" alt="thumbnail">
                                </a>
                            </div>
                            <div class="course-info">
                                <div class="pull-left course-img">
                                    <a href="{{route('profil.user', ['username' => $row->get_user->username])}}">
                                        <img src="{{$row->get_user->get_bio->foto != "" ?
                                        asset('storage/users/foto/'.$row->get_user->get_bio->foto) :
                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar">
                                        <span>{{$row->get_user->name}}</span>
                                    </a>
                                    <p style="color: #ffc100">
                                        @if(round($rate * 2) / 2 == 1)
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 2)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 3)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 4)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 0.5)
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 1.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 2.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 3.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 4.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @endif
                                    </p>
                                </div>
                                <div class="pull-right price">
                                    <p>Rp{{number_format($row->harga,2,',','.')}}</p>
                                </div>
                            </div>
                            <div class="text-center middle-info">
                                <h3><a href="{{route('detail.proyek',['username' => $row->get_user->username, 'judul' =>
                                $row->permalink])}}">{{$row->judul}}</a></h3>
                                {!! \Illuminate\Support\Str::words($row->deskripsi,10,'...') !!}
                            </div>
                            <div class="date-info">
                                <div class="pull-left">
                                    <p data-toggle="tooltip" title="Deadline">
                                        <i class="fa fa-calendar-week"></i> {{$row->waktu_pengerjaan}} hari</p>
                                </div>
                                <div class="pull-right">
                                    <p data-toggle="tooltip" title="Total bid">
                                        <i class="fa fa-paper-plane"></i> {{$row->get_bid->count()}} bid</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach($layanan as $row)
                    @php
                        $ulasan_pekerja = \App\Model\ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($row) {
                            $q->where('user_id', $row->user_id);
                        })->count();
                        $ulasan_layanan = \App\Model\UlasanService::whereHas('get_pengerjaan', function($q) use ($row) {
                            $q->where('user_id', $row->user_id);
                        })->count();
                        $rate = $ulasan_pekerja + $ulasan_layanan > 0 ?
                        $row->get_user->get_bio->total_bintang_pekerja / ($ulasan_pekerja + $ulasan_layanan) : 0;
                    @endphp
                    <div class="item layanan">
                        <div class="our-courses">
                            <div class="img-wrapper">
                                <a href="{{route('detail.layanan',['username' => $row->get_user->username, 'judul' =>
                                $row->permalink])}}">
                                    <img src="{{$row->thumbnail != "" ? asset('storage/layanan/thumbnail/'.$row->thumbnail)
                                    : asset('images/slider/beranda-pekerja.jpg')}}" alt="thumbnail">
                                </a>
                            </div>
                            <div class="course-info">
                                <div class="pull-left course-img">
                                    <a href="{{route('profil.user', ['username' => $row->get_user->username])}}">
                                        <img src="{{$row->get_user->get_bio->foto != "" ?
                                        asset('storage/users/foto/'.$row->get_user->get_bio->foto) :
                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar">
                                        <span>{{$row->get_user->name}}</span>
                                    </a>
                                    <p style="color: #ffc100">
                                        @if(round($rate * 2) / 2 == 1)
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 2)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 3)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 4)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 0.5)
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 1.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 2.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 3.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 4.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @endif
                                    </p>
                                </div>
                                <div class="pull-right price">
                                    <p>Rp{{number_format($row->harga,2,',','.')}}</p>
                                </div>
                            </div>
                            <div class="text-center middle-info">
                                <h3><a href="{{route('detail.layanan',['username' => $row->get_user->username, 'judul' =>
                                $row->permalink])}}">{{$row->judul}}</a></h3>
                                {!! \Illuminate\Support\Str::words($row->deskripsi,10,'...') !!}
                            </div>
                            <div class="date-info">
                                <div class="pull-left">
                                    <p data-toggle="tooltip" title="Deadline">
                                        <i class="fa fa-calendar-week"></i> {{$row->hari_pengerjaan}} hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach($pekerja as $row)
                    @php
                        $ulasan_pekerja = \App\Model\ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($row) {
                            $q->where('user_id', $row->user_id);
                        })->count();
                        $ulasan_layanan = \App\Model\UlasanService::whereHas('get_pengerjaan', function($q) use ($row) {
                            $q->where('user_id', $row->user_id);
                        })->count();
                        $rate = $ulasan_pekerja + $ulasan_layanan > 0 ?
                        $row->total_bintang_pekerja / ($ulasan_pekerja + $ulasan_layanan) : 0;
                    @endphp
                    <div class="item pekerja">
                        <div class="our-courses">
                            <div class="img-wrapper">
                                <a href="{{route('profil.user', ['username' => $row->get_user->username])}}">
                                    <img src="{{$row->foto != "" ? asset('storage/users/foto/'.$row->foto) :
                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar">
                                    <span>{{$row->get_user->name}}</span>
                                </a>
                            </div>
                            <div class="course-info">
                                <div class="pull-left course-img">
                                    <a href="{{route('profil.user', ['username' => $row->get_user->username])}}">
                                        <img src="{{$row->foto != "" ? asset('storage/users/foto/'.$row->foto) :
                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar">
                                        <span>{{$row->get_user->name}}</span>
                                    </a>
                                    <p style="color: #ffc100">
                                        @if(round($rate * 2) / 2 == 1)
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 2)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 3)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 4)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 0.5)
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 1.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 2.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 3.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        @elseif(round($rate * 2) / 2 == 4.5)
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-center middle-info">
                                <blockquote class="quotes"><em>{{$row->status != "" ? $row->status : 'Status (-)'}}</em></blockquote>
                            </div>
                            <div class="date-info">
                                <div class="pull-left">
                                    <p data-toggle="tooltip" title="Total Proyek"><i
                                            class="fa fa-business-time"></i> {{$row->get_user->get_project->count()}}
                                    </p>
                                </div>
                                <div class="pull-right">
                                    <p data-toggle="tooltip" title="Total Poin"><i
                                            class="fa fa-trophy"></i> {{$row->total_bintang_pekerja}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                        </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-lg-12">
                    <a id="btn-more" href="{{route('cari.data', ['filter' => 'proyek'])}}"
                       class="btn2 btn-sm" style="border-radius: 0">
                        <b style="color: white">TAMPILKAN LEBIH BANYAK</b></a>
                </div>
            </div>
        </div>
    </section>

    <!-- daftar testimoni -->
    <section class="clients-testimonials padding">
        <div class="container bot-40">
            <h2 class="text-heading border-3 text-center">Testimoni <strong class="strong-green">Pengguna</strong></h2>
{{--            <h3 class="text-heading">Berikut adalah ulasan dari pengguna {{env('APP_NAME')}}</h3>--}}
        </div>
        <div class="container">
            <div id="testimoni" class="testi-slider testi-dark">
                @foreach($testimoni->chunk(2) as $two)
                    <div class="education-testimonials">
                        @foreach($two as $row)
                            <div class="col-md-6 item">
                                <div class="education-content">
                                    <div class="img-info">
                                        <img src="{{$row->get_user->get_bio->foto != "" ?
                                        asset('storage/users/foto/'.$row->get_user->get_bio->foto) :
                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar">
                                    </div>
                                    <div class="txt-info">
                                        <h5 style="color: #ffc100">
                                            @if($row->bintang == 1)
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 2)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 3)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 4)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            @elseif($row->bintang == 0.5)
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 1.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 2.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 3.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 4.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                            @endif
                                        </h5>
                                        <p>{{$row->deskripsi}}</p>
                                        <h3>{{$row->get_user->name}}</h3>
                                        <span><i class="fa fa-clock"></i> {{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- form testimoni -->
    <section class="subscribe bg-green">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="subscribe-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="title-form">
                                    <h3 class="white">{{$cek != null ? 'SUNTING/HAPUS ULASAN' : 'ULAS '.env('APP_NAME')}}</h3>
                                    @if($cek != null)
                                        <a href="{{route('hapus.testimoni',['id' => encrypt($cek->id)])}}"
                                           class="btn btn-grey delete-data">HAPUS</a>
                                    @else
                                        <p style="line-height: unset;">Beri kami ulasan dengan membagikan pengalaman
                                            Anda tentang layanan kami!</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="newsletter">
                                    <form action="{{route('kirim.testimoni')}}" class="comment-form" method="post">
                                        @csrf
                                        <input type="hidden" name="check_form"
                                               value="{{$cek != null ? $cek->id : 'create'}}">
                                        <div class="input-form" style="width: 70%">
                                            <textarea name="comment" id="comment" class="form-control"
                                                      style="resize: vertical; height: 75px; color: #fff"
                                                      placeholder="Bagikan pengalaman Anda tentang layanan kami disini&hellip;"
                                                      required>{{$cek != null ? $cek->comment : ''}}</textarea>
                                        </div>
                                        <fieldset id="rating" class="rating" aria-required="true">
                                            <label class="full" for="star5" data-toggle="tooltip"
                                                   title="Terbaik"></label>
                                            <input type="radio" id="star5" name="rating" value="5" required {{$cek != null
                                            && $cek->rate == '5' ? 'checked' : ''}}>

                                            <label class="half" for="star4half" data-toggle="tooltip"
                                                   title="Keren"></label>
                                            <input type="radio" id="star4half" name="rating" value="4.5" {{$cek != null
                                            && $cek->rate == '4.5' ? 'checked' : ''}}>

                                            <label class="full" for="star4" data-toggle="tooltip"
                                                   title="Cukup baik"></label>
                                            <input type="radio" id="star4" name="rating" value="4" {{$cek != null
                                            && $cek->rate == '4' ? 'checked' : ''}}>

                                            <label class="half" for="star3half" data-toggle="tooltip"
                                                   title="Baik"></label>
                                            <input type="radio" id="star3half" name="rating" value="3.5" {{$cek != null
                                            && $cek->rate == '3.5' ? 'checked' : ''}}>

                                            <label class="full" for="star3" data-toggle="tooltip"
                                                   title="Standar"></label>
                                            <input type="radio" id="star3" name="rating" value="3" {{$cek != null
                                            && $cek->rate == '3' ? 'checked' : ''}}>

                                            <label class="half" for="star2half" data-toggle="tooltip"
                                                   title="Cukup buruk"></label>
                                            <input type="radio" id="star2half" name="rating" value="2.5" {{$cek != null
                                            && $cek->rate == '2.5' ? 'checked' : ''}}>

                                            <label class="full" for="star2" data-toggle="tooltip" title="Buruk"></label>
                                            <input type="radio" id="star2" name="rating" value="2" {{$cek != null
                                            && $cek->rate == '2' ? 'checked' : ''}}>

                                            <label class="half" for="star1half" data-toggle="tooltip"
                                                   title="Sangat buruk"></label>
                                            <input type="radio" id="star1half" name="rating" value="1.5" {{$cek != null
                                            && $cek->rate == '1.5' ? 'checked' : ''}}>

                                            <label class="full" for="star1" data-toggle="tooltip"
                                                   title="Menyedihkan"></label>
                                            <input type="radio" id="star1" name="rating" value="1" {{$cek != null
                                            && $cek->rate == '1' ? 'checked' : ''}}>

                                            <label class="half" for="starhalf" data-toggle="tooltip"
                                                   title="Sangat menyedihkan"></label>
                                            <input type="radio" id="starhalf" name="rating" value="0.5" {{$cek != null
                                            && $cek->rate == '0.5' ? 'checked' : ''}}>
                                        </fieldset>
                                        <input type="submit" class="btn education-btn-2 color-1" value="{{$cek != null
                                        ? 'SIMPAN' : 'KIRIM'}}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        var keyword = $("#keyword");

        $(function () {
            $("#testimoni").owlCarousel({
                navigation: false,
                slideSpeed: 600,
                autoPlay: 6000,
                singleItem: true,
                pagination: true,
                navigationText: [
                    "<i class='fa fa-caret-left'></i>",
                    "<i class='fa fa-caret-right'></i>"
                ],
            });
        });

        $("#filter-pencarian > li").on("click", function () {
            $("#btn_reset").show();
            $("#txt_filter").text($(this).text());
            $("#form-pencarian input[name='filter']").val($(this).data('filter'));
            keyword.val(null).removeAttr('disabled').attr('required', 'required')
                .attr('placeholder', 'Cari ' + $(this).text().toLowerCase() + '...').focus();
        });

        keyword.on("keyup", function () {
            $("#btn_reset").show();
        });

        keyword.autocomplete({
            source: function (request, response) {
                $.getJSON('/cari/judul/data?filter=' + $("#form-pencarian input[name='filter']").val() + '&q=' + keyword.val(), {
                    name: request.term,
                }, function (data) {
                    response(data);
                });
            },
            focus: function (event, ui) {
                event.preventDefault();
            },
            select: function (event, ui) {
                event.preventDefault();
                keyword.val(ui.item.q);
            }
        });

        $("#btn_reset").on("click", function () {
            $(this).hide();
            $("#txt_filter").text('FILTER');
            $("#form-pencarian input[name='filter']").removeAttr('value');
            keyword.removeAttr('required').attr('disabled', 'disabled').attr('placeholder', 'Keyword');
        });

        $("#form-pencarian").on('submit', function (e) {
            e.preventDefault();
            var filter = $("#form-pencarian input[name='filter']").val();

            if (!filter) {
                swal('PERHATIAN!', 'Silahkan pilih filter pencarian terlebih dahulu, terimakasih.', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        $(window).load(function () {
            var $daftar_terbaru = $("#update-terbaru");

            $daftar_terbaru.isotope({
                itemSelector: '.item',
                filter: '.proyek',
                masonry: {
                    columnWidth: 337,
                    isFitWidth: true,
                }
            });

            $('#filter-daftar a').on('click', function () {
                if ($(this).hasClass('current')) {
                    return false;
                }

                $(this).parents().find('.current').removeClass('current');
                $(this).addClass('current');

                $daftar_terbaru.isotope({
                    filter: $(this).attr('data-filter'),
                });

                if ($(this).attr('data-id') == 'proyek') {
                    $("#btn-more").attr('href', '{{route('cari.data', ['filter' => 'proyek'])}}');
                    $("#btn-more b").html('<i class="fa fa-business-time"></i> TAMPILKAN LEBIH');
                } else if ($(this).attr('data-id') == 'layanan') {
                    $("#btn-more").attr('href', '{{route('cari.data', ['filter' => 'layanan'])}}');
                    $("#btn-more b").html('<i class="fa fa-tools"></i> TAMPILKAN LEBIH');
                } else {
                    $("#btn-more").attr('href', '{{route('cari.data', ['filter' => 'pekerja'])}}');
                    $("#btn-more b").html('<i class="fa fa-hard-hat"></i> TAMPILKAN LEBIH');
                }

                return false;
            });
            $('#filter-pencarian a').on('click', function () {
                if ($(this).hasClass('current')) {
                    return false;
                }

                $(this).parents().find('.current').removeClass('current');
                $(this).addClass('current');

                // $daftar_terbaru.isotope({
                //     filter: $(this).attr('data-filter'),
                });
        });

        @if(session('testimoni'))
        swal('Sukses!', '{{ session('testimoni') }}', 'success');
        @endif
    </script>
@endpush
