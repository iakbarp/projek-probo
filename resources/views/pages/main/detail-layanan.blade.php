@extends('layouts.mst')
@section('title', 'Detail Layanan: '.$layanan->judul.' – '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-tabs-responsive.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        [data-scrollbar] {
            max-height: 350px;
        }

        .content-area {
            position: relative;
            cursor: pointer;
            overflow: hidden;
            margin: 1em auto;
        }

        .custom-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: all 400ms ease-in-out;
            height: 100%;
        }

        .custom-overlay:hover {
            opacity: 1;
        }

        .custom-text {
            position: absolute;
            top: 50%;
            left: 10px;
            right: 10px;
            transform: translateY(-50%);
            color: #eee;
        }

        .content-area img {
            transition: transform .5s ease;
        }

        .content-area:hover img {
            transform: scale(1.2);
        }

        .lg-backdrop {
            z-index: 9999999;
        }

        .lg-outer {
            z-index: 10000000;
        }

        .lg-sub-html h4 {
            color: #eee;
        }

        .lg-sub-html p {
            color: #bbb;
        }

        .sub-menu {
            font-size: 14px;
        }

        .sub-menu li {
            border-bottom: 1px solid #eee;
        }

        .sub-menu a {
            display: block;
            text-decoration: none;
            color: #4d4d4d;
            padding: 12px;
            padding-left: 15px;
            -webkit-transition: all 0.25s ease;
            -o-transition: all 0.25s ease;
            transition: all 0.25s ease;
        }

        .sub-menu img {
            transition: transform .5s ease;
        }

        .sub-menu a:hover .sub-menu-name,
        .sub-menu a:focus .sub-menu-name,
        .sub-menu a:active .sub-menu-name {
            color: #122752 !important;
        }

        .sub-menu a:hover img,
        .sub-menu a:focus img,
        .sub-menu a:active img,
        .sub-menu a:hover .sub-menu-blockquote,
        .sub-menu a:focus .sub-menu-blockquote,
        .sub-menu a:active .sub-menu-blockquote {
            border-color: #122752;
        }

        .sub-menu a .list-category {
            text-transform: uppercase;
        }

        .sub-menu a .list-category i {
            margin: auto .5em;
            color: #4d4d4d;
        }
    </style>
@endpush
@section('content')
    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="img-card">
                                    <img style="width: 100%" alt="Thumbnail" src="{{$layanan->thumbnail == "" ?
                                    asset('images/slider/beranda-pekerja.jpg') :
                                    asset('storage/layanan/thumbnail/' . $layanan->thumbnail)}}">
                                </div>

                                <div class="card-content">
                                    <div class="card-title text-center">
                                        <h3 style="color: black;margin: 0 0 .5em 0;text-transform: none">
                                            Rp{{number_format($layanan->harga,2,',','.')}}</h3>
                                    </div>
                                    <div class="card-title">
                                        <div class="row text-center">
                                            <div class="col-lg-12">
                                                <button id="btn_order" style="border: 1px solid #eee"
                                                        class="btn2 btn-block {{$cek > 0}}"
                                                    {{$cek > 0 ? 'disabled' : ''}}>
                                                    <small style="color: white">{{$cek > 0 ? 'TELAH DI PESAN' : 'GUNAKAN LAYANAN SAYA'}}</small>
                                                </button>
                                            </div>
                                        </div>
                                        <hr style="margin: 10px 0">
                                        <table style="font-size: 14px;margin-top: 1em">
                                            <tr>
                                                <td><i class="fa fa-calendar-week"></i></td>
                                                <td>&nbsp;Batas Waktu</td>
                                                <td>: {{$layanan->hari_pengerjaan}} hari</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-tie"></i></td>
                                                <td>&nbsp;Total Klien</td>
                                                <td>: {{count($layanan->get_pengerjaan_layanan)}} klien</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i></td>
                                                <td>&nbsp;Diposting Tanggal</td>
                                                <td>
                                                    : {{$layanan->created_at->formatLocalized('%d %B %Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-clock"></i></td>
                                                <td>&nbsp;Update Terakhir</td>
                                                <td style="text-transform: none;">
                                                    : {{$layanan->updated_at->diffForHumans()}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <br>
                                <div class="img-card avatar">
                                    <img class="img-thumbnail" style="width: 35%" alt="Avatar" src="{{$user->get_bio->foto== "" ?
                                    asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                    asset('storage/users/foto/'.$user->get_bio->foto)}}">
                                </div>

                                <div class="card-content">
                                    <div class="card-title text-center">
                                        <a href="{{$user->id == Auth::id() ? route('user.profil') :
                                        route('profil.user',['username' => $user->username])}}">
                                            <h4 style="color: #122752">{{$user->name}}</h4></a>
                                        <small style="text-transform: none">
                                            {{$user->get_bio->status != "" ? $user->get_bio->status : 'Status (-)'}}
                                        </small>
                                    </div>
                                    <div class="card-title">
                                        <table style="font-size: 14px;">
                                            <tr>
                                                <td><i class="fa fa-map-marker-alt"></i></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    @if($user->get_bio->kota_id != "" && $user->get_bio->kewarganegaraan != "")
                                                        {{$user->get_bio->get_kota->nama.', '.$user->get_bio->get_kota->get_provinsi->nama.', '.$user->get_bio->kewarganegaraan}}
                                                    @else
                                                        Kabupaten/Kota, Provinsi (-)
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-tools"></i></td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_service->count()}} layanan</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-thumbs-up"></i></td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: none">
                                                    <span style="color: #ffc100">
                                                        @if(round($rating_pekerja * 2) / 2 == 1)
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 2)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 3)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 4)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 0.5)
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 1.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 2.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 3.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 4.5)
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
                                                        @endif </span>
                                                    <b>{{round($rating_pekerja * 2) / 2}}</b>
                                                    ({{count($ulasan_pekerja)}}
                                                    ulasan)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i></td>
                                                <td>&nbsp;</td>
                                                <td>Bergabung Sejak : {{$user->created_at->formatLocalized('%d %B %Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-clock"></i></td>
                                                <td>&nbsp;</td>
                                                <td>Update Terakhir : {{$user->updated_at->diffForHumans()}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="row card-data div-data">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <small>{{$layanan->judul}}</small>
                                        <hr class="mt-0">
                                        <small data-scrollbar>
                                            {!! $layanan->deskripsi !!}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row card-data div-data">
                        <div class="col-lg-12">
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                    <li role="presentation" class="active">
                                        <a class="nav-item nav-link" href="#hasil" id="hasil-tab" role="tab"
                                           data-toggle="tab" aria-controls="hasil" aria-expanded="true">
                                            <i class="fa fa-images mr-2"></i>HASIL PENGERJAAN
                                            <span class="badge badge-secondary">
                                                @if(!is_null($hasil))
                                                    {{count($hasil->file_hasil) > 999 ? '999+' : count($hasil->file_hasil)}}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="next">
                                        <a class="nav-item nav-link" href="#ulasan" id="ulasan-tab"
                                           role="tab" data-toggle="tab" aria-controls="ulasan"
                                           aria-expanded="true"><i class="fa fa-thumbs-up mr-2"></i>ULASAN KLIEN
                                            <span class="badge badge-secondary">
                                                {{count($ulasan) > 999 ? '999+' : count($ulasan)}}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="hasil"
                                         aria-labelledby="hasil-tab" style="border: none">
                                        @if(!is_null($hasil))
                                            <div class="row" id="lightgallery">
                                                @foreach($hasil->file_hasil as $file)
                                                    <div class="col-md-3 item"
                                                         data-src="{{asset('storage/layanan/hasil/'.$file)}}"
                                                         data-sub-html="<h4>{{$layanan->judul}}</h4><p>{{$file}}</p>">
                                                        <div class="content-area">
                                                            <img alt="File hasil"
                                                                 src="{{asset('storage/layanan/hasil/'.$file)}}"
                                                                 class="img-responsive">
                                                            <div class="custom-overlay">
                                                                <div class="custom-text">
                                                                    <b>{{$file}}</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>Tidak ada hasil.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="ulasan"
                                         aria-labelledby="ulasan-tab" style="border: none">
                                        <ul class="sub-menu">
                                            @if(count($ulasan) > 0)
                                                @foreach($ulasan as $row)
                                                    <li>
                                                        <a href="{{route('profil.user',['username' => $row->get_user->username])}}">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img alt="avatar" src="{{$row->get_user->get_bio->foto
                                                                        == "" ? asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                                                        asset('storage/users/foto/'.$row->get_user->get_bio->foto)}}"
                                                                         class="media-object img-thumbnail"
                                                                         width="64" style="border-radius: 100%">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-user-tie sub-menu-name mr-2"
                                                                           style="color: #4d4d4d"></i>
                                                                        <b class="sub-menu-name">{{$row->get_user->name}}</b>
                                                                        <i class="fa fa-star"
                                                                           style="color: #ffc100;margin: 0 0 0 .5rem"></i>
                                                                        <b>{{round($row->bintang * 2) / 2}}</b>
                                                                        <span class="pull-right"
                                                                              style="color: #999">
                                                                                <i class="fa fa-clock"
                                                                                   style="color: #aaa;margin: 0"></i>
                                                                                {{$row->created_at->diffForHumans()}}
                                                                            </span>
                                                                    </p>
                                                                    <blockquote class="sub-menu-blockquote">
                                                                        {!! $row->deskripsi !!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li style="border: none">Tidak ada ulasan.</li>
                                            @endif
                                        </ul>
                                    </div>
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
    <script src="{{asset('vendor/masonry/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <script>
        var $btn = $("#btn_order");
        $(function () {
            @if(session('pesanan'))
            swal({
                title: 'Sukses!',
                text: '{{session('pesanan')['message']}} Apakah Anda ingin melakukan pembayaran sekarang? ' +
                    'Klik tombol "Ya" maka Anda akan langsung dialihkan ke halaman "Dashboard Klien: Layanan".',
                icon: 'success',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = '{{route('dashboard.klien.layanan',['pesanan_id' => session('pesanan')['data']])}}';
                }
            });
            @endif
        });

        $btn.on({
            mouseenter: function () {
                $(this).removeClass('ld ld-breath');
            },
            mouseleave: function () {
                $(this).addClass('ld ld-breath');
            }
        });

        $btn.on('click', function () {
            @auth
            @if(Auth::user()->isOther())
            @if($user->id == Auth::id())
            swal('PERHATIAN!', 'Maaf, Anda tidak bisa memesan layanan Anda sendiri.', 'warning');
            @else
            swal({
                title: 'Konfirmasi Pengajuan Layanan',
                text: 'Apakah Anda yakin akan memesan layanan "{{$layanan->judul}}" ' +
                    'yang disediakan oleh "{{$user->name}}"? Anda tidak dapat mengembalikannya!',
                icon: '{{asset('images/red-icon.png')}}',
                dangerMode: true,
                buttons: ["Tidak", "Ajukan"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = '{{route('pesan.layanan',['username' => $user->username, 'judul' => $layanan->permalink])}}';
                }
            });
            @endif
            @else
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Klien/Pekerja.', 'warning');
            @endif
            @else
            openLoginModal();
            @endauth
        });

        $("#hasil-tab").on("shown.bs.tab", function () {
            var hasil = $("#lightgallery");
            hasil.masonry({
                itemSelector: '.item'
            });
            hasil.lightGallery({
                selector: '.item',
                loadYoutubeThumbnail: true,
                youtubeThumbSize: 'default',
            });
        });

        $(".sub-menu li a").on({
            mouseenter: function () {
                $(this).parent().css('border-color', '#122752');
            },
            mouseleave: function () {
                $(this).parent().css('border-color', '#eee');
            }
        });

        $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
            var $target = $(e.target);
            var $tabs = $target.closest('.nav-tabs-responsive');
            var $current = $target.closest('li');
            var $parent = $current.closest('li.dropdown');
            $current = $parent.length > 0 ? $parent : $current;
            var $next = $current.next();
            var $prev = $current.prev();
            var updateDropdownMenu = function ($el, position) {
                $el
                    .find('.dropdown-menu')
                    .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                    .addClass('pull-xs-' + position);
            };

            $tabs.find('>li').removeClass('next prev');
            $prev.addClass('prev');
            $next.addClass('next');

            updateDropdownMenu($prev, 'left');
            updateDropdownMenu($current, 'center');
            updateDropdownMenu($next, 'right');
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
        }
    </script>
@endpush
