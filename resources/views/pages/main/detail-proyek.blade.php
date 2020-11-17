@extends('layouts.mst')
@section('title', 'Detail Tugas/Proyek: '.$proyek->judul.' – '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-tabs-responsive.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        [data-scrollbar] {
            max-height: 350px;
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
                                    <img style="width: 50%" alt="Thumbnail" src="{{$proyek->thumbnail == "" ?
                                    asset('images/slider/beranda-proyek.jpg') :
                                    asset('storage/proyek/thumbnail/' . $proyek->thumbnail)}}">
                                </div>

                                <div class="card-content">
                                    <div class="card-title text-center">
                                        <h3 style="color: #122752;margin: 0 0 .5em 0;text-transform: none">
                                            Rp{{number_format($proyek->harga,2,',','.')}}</h3>
                                    </div>
                                    <div class="card-title">
                                        <div class="row text-center">
                                            <div class="col-lg-12">
                                                <button id="btn_bid" style="border: 1px solid #eee"
                                                        class="btn2 btn-sm btn-block"
                                                    {{$cek > 0 ? 'disabled' : ''}}>
                                                    <span style="color: white;">{{$cek > 0 ? 'BID TELAH DIAJUKAN' : 'BID'}}&nbsp;<i class="fa fa-paper-plane mr-2"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                        <hr style="margin: 10px 0">
                                        <table style="font-size: 14px;margin-top: 1em">
                                            <tr>
                                                <td><i class="fa fa-business-time"></i></td>
                                                <td>&nbsp;Jenis Tugas/Proyek</td>
                                                <td>: {{$proyek->pribadi == false ? 'PUBLIK' : 'PRIVAT'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-week"></i></td>
                                                <td>&nbsp;Batas Waktu</td>
                                                <td>: {{$proyek->waktu_pengerjaan}} hari</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-tie"></i></td>
                                                <td>&nbsp;Total Bid</td>
                                                <td>: {{is_null($proyek->get_bid) ? 0 : count($proyek->get_bid)}}bid
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i></td>
                                                <td>&nbsp;Diposting Tanggal</td>
                                                <td>
                                                    : {{$proyek->created_at->formatLocalized('%d %B %Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-clock"></i></td>
                                                <td>&nbsp;Update Terakhir</td>
                                                <td style="text-transform: none;">
                                                    : {{$proyek->updated_at->diffForHumans()}}
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
                                        <hr style="margin: 10px 0">
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
                                                <td><i class="fa fa-comments"></i></td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: none">
                                            <span style="color: #ffc100">
                                                @if(round($rating_klien * 2) / 2 == 1)
                                                    <i class="fa fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 2)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 3)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 4)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 5)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 0.5)
                                                    <i class="fa fa-star-half-alt"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 1.5)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-alt"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 2.5)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-alt"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 3.5)
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-alt"></i>
                                                    <i class="far fa-star"></i>
                                                @elseif(round($rating_klien * 2) / 2 == 4.5)
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
                                                    <b>{{round($rating_klien * 2) /2}}</b> ({{count($ulasan_klien)}}
                                                    ulasan)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-business-time"></i></td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_project->count()}} proyek</td>
                                            </tr>
                                        </table>
                                        <table style="font-size: 14px; margin-top: 0">
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i></td>
                                                <td>&nbsp;Bergabung Sejak</td>
                                                <td>
                                                    : {{$user->created_at->formatLocalized('%d %B %Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-clock"></i></td>
                                                <td>&nbsp;Update Terakhir</td>
                                                <td style="text-transform: none;">
                                                    : {{$user->updated_at->diffForHumans()}}
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
                                        <small>{{$proyek->judul}}</small>
                                        <hr class="mt-0">
                                        <span data-scrollbar>
                                            {!! $proyek->deskripsi !!}
                                        </span>
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
                                        <a class="nav-item nav-link" href="#lampiran" id="lampiran-tab" role="tab"
                                           data-toggle="tab" aria-controls="lampiran" aria-expanded="true">
                                            <i class="far fa-file-alt mr-2"></i>LAMPIRAN
                                            <span class="badge badge-secondary">
                                                @if(!is_null($proyek->lampiran))
                                                    {{count($proyek->lampiran) > 999 ? '999+' : count($proyek->lampiran)}}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="next">
                                        <a class="nav-item nav-link" href="#bid" id="bid-tab"
                                           role="tab" data-toggle="tab" aria-controls="bid"
                                           aria-expanded="true"><i class="fa fa-paper-plane mr-2"></i>BIDDER
                                            <span class="badge badge-secondary">
                                                 @if(!is_null($proyek->get_bid))
                                                    {{count($proyek->get_bid) > 999 ? '999+' : count($proyek->get_bid)}}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="lampiran"
                                         aria-labelledby="lampiran-tab" style="border: none">
                                        <ul class="sub-menu">
                                            @if(!is_null($proyek->lampiran))
                                                @foreach($proyek->lampiran as $file)
                                                    @php
                                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                        if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {
                                                            $src = asset('storage/proyek/lampiran/' .$file);
                                                        } else {
                                                            $src = asset('images/files.png');
                                                        }
                                                    @endphp
                                                    <li>
                                                        <a href="{{asset('storage/proyek/lampiran/' .$file)}}">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img width="100" alt="lampiran" src="{{$src}}"
                                                                         class="media-object img-thumbnail">
                                                                </div>
                                                                <div class="media-body">
                                                                    <blockquote style="text-transform: none">
                                                                        {{$file}}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li style="border: none">Tidak ada lampiran.</li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="bid" aria-labelledby="bid-tab"
                                         style="border: none">
                                        <ul class="sub-menu">
                                            @if(!is_null($proyek->get_bid))
                                                @foreach($proyek->get_bid as $row)
                                                    @php
                                                        $pekerja = $row->get_user;
                                                        $ulasan_pekerja = \App\Model\ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($pekerja) {
                                                            $q->where('user_id', $pekerja->id);
                                                        })->get();
                                                        $ulasan_layanan = \App\Model\UlasanService::whereHas('get_pengerjaan', function ($q) use ($pekerja) {
                                                            $q->where('user_id', $pekerja->id);
                                                        })->count();
                                                        $rating_pekerja = count($ulasan_pekerja) + $ulasan_layanan > 0 ?
                                                            $pekerja->get_bio->total_bintang_pekerja / (count($ulasan_pekerja) + $ulasan_layanan) : 0;
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('profil.user',['username' => $pekerja->username])}}">
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <img alt="avatar" src="{{$pekerja->get_bio->foto
                                                                        == "" ? asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                                                        asset('storage/users/foto/'.$pekerja->get_bio->foto)}}"
                                                                         class="media-object img-thumbnail"
                                                                         width="64" style="border-radius: 100%">
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-user-tie sub-menu-name mr-2"
                                                                           style="color: #4d4d4d"></i>
                                                                        <b class="sub-menu-name">{{$pekerja->name}}</b>
                                                                        <i class="fa fa-star"
                                                                           style="color: #ffc100;margin: 0 0 0 .5rem"></i>
                                                                        <b>{{round($rating_pekerja * 2) / 2}}</b>
                                                                        <span class="pull-right"
                                                                              style="color: #999">
                                                                                <i class="fa fa-clock"
                                                                                   style="color: #aaa;margin: 0"></i>
                                                                                {{$row->created_at->diffForHumans()}}
                                                                            </span>
                                                                    </p>
                                                                    <blockquote class="sub-menu-blockquote">
{{--                                                                        {!! !is_null($pekerja->get_bio->summary) ?--}}
{{--                                                                        $pekerja->get_bio->summary : $pekerja->name.--}}
{{--                                                                        ' belum menuliskan apapun di profilnya.' !!}--}}
                                                                        Harga : RP. 5.000.000,00
                                                                        <br>
                                                                        Batas Waktu : 7 Hari
                                                                        <br>
                                                                        Fitur yang ditawarkan : Tampilan Menu
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li style="border: none">Tidak ada bid.</li>
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
        <div class="modal" tabindex="-1" role="dialog" id="modal_nego">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{asset('images/logo/undagi_logo.png')}}" width="120">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="BiayaProyek" class="col-sm-4 col-form-label">Biaya Proyek</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="Biaya">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BatasWaktu" class="col-sm-4 col-form-label">Batas Waktu</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="Waktu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Fitur" class="col-sm-4 col-form-label">Fitur yang ditawarkan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="Fitur Tambahan">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <div style="background-color: #E1E2DF;width: 525px;height: 250px;overflow: scroll;border: 1px solid black;padding: 2px 40px">
                                            <h2>Terms of Use</h2>
                                            These Terms and Conditions constitute an agreement (“Agreement”) between you (“you”, “your”, “user”, “Customer”) and the Company.Avocado gumbo artichoke ricebean groundnut tigernut. Daikon kakadu plum water spinach garbanzo eggplant fava bean chard rock melon carrot rutabaga water chestnut broccoli courgette onion.

                                            <h2>Eligibility and Identity.</h2>
                                            To be eligible to use our Services, you must be at least 13 years old. Sorrel jícama tomato silver beet wattle seed black-eyed pea garlic fennel tigernut okra beetroot shallot. Soko shallot melon dandelion bamboo shoot chickpea soybean pumpkin kakadu plum parsley ricebean grape courgette courgette jícama tatsoi. Black-eyed pea gourd tomatillo arugula cucumber celery mustard black-eyed pea cauliflower soybean rutabaga turnip groundnut.

                                            <h2>Termination</h2>
                                            You may terminate this Agreement at any time by ceasing all use of the Services and by notifying us. The Company may terminate this Agreement, at any time, without notice to you, if it believes, in its sole judgment, that you have breached or may breach any term or condition of this Agreement. Fennel garlic melon broccoli kohlrabi dulse black-eyed pea chicory watercress shallot bamboo shoot cucumber rutabaga ricebean gourd chickweed gumbo. Burdock fennel sorrel cress collard greens tomato tigernut salad chickweed yarrow water spinach catsear earthnut pea cabbage dulse potato. Onion courgette bitterleaf rutabaga tomatillo tigernut groundnut courgette water spinach tomato. Celery ricebean cabbage salsify caulie watercress cress collard greens potato chard gourd pea sprouts cucumber dulse gram. Leek summer purslane tatsoi catsear celtuce broccoli rabe onion zucchini.

                                            <h2>Use of Services & Account</h2>
                                            You represent and warrant that you possess the legal right and ability to enter into this Agreement. You agree not to use the Materials, Content, Services, and your Account for any unlawful or abusive purpose or in any way which interferes with our ability to provide Services to our customers, or which damages our property. Chickpea gourd coriander daikon zucchini lettuce tomatillo sierra leone bologi maize parsnip grape melon kohlrabi welsh onion. Celery wakame corn garlic courgette silver beet cabbage gram amaranth jícama bitterleaf. Ricebean bunya nuts prairie turnip water chestnut artichoke cauliflower watercress gourd cabbage okra broccoli rabe. Burdock leek sorrel radicchio azuki bean collard greens winter purslane broccoli rabe gourd water chestnut pumpkin gumbo. Azuki bean green bean kohlrabi kombu aubergine salsify lotus root turnip lentil radicchio nori eggplant sorrel.

                                            <h2>Modification to Service</h2>
                                            The Company may change, suspend, or discontinue all or any part of the Service at any time, with or without reason. You acknowledge that the operation of the Service may from time to time encounter technical or other problems and may not necessarily continue uninterrupted or without technical or other errors and The Company shall not be responsible to you or others for any such interruptions, errors or problems or an outright discontinuance of the Service.

                                            <h2>Intellectual Property Ownership</h2>
                                            All Materials, Services, Accounts, and content, including, but not limited to, policy information, text, software, music, sound, photographs, video, graphics, the arrangement of text and images, commercially produced information, and other material contained on the Site or through the Services (“Content”), are provided by The Company unless indicated otherwise. Welsh onion tigernut broccoli asparagus brussels sprout jícama eggplant earthnut pea cress chickpea gourd zucchini. Radicchio lentil cucumber groundnut endive kohlrabi winter purslane. Seakale plantain quandong celtuce shallot fennel seakale epazote groundnut dandelion.

                                            <h2>Privacy</h2>
                                            Please see our <a href="">Privacy Policy</a> as set forth on the site.

                                            <h2>About These Terms</h2>
                                            <p>These Terms and Conditions are just a sample and are not legally binding. Real Terms of Services do not (usually) contain vegetables...</p>
                                    </div>
                                    <label for="bid" class="pull-right"
                                           style="text-transform: none">
                                        <input type="checkbox" style="background-color: grey" required>	&nbsp;Ya, Saya setuju dengan kontrak ini
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn2" id="submit_nego"><span style="color: white">Ajukan Bid</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var $btn = $("#btn_bid");
        var $submitNego = $("#submit_nego");

        $(function () {
            @if(session('bid'))
            swal({
                title: 'Sukses!',
                text: '{{session('bid')}} Apakah Anda ingin melihat status bid Anda sekarang? ' +
                    'Klik tombol "Ya" maka Anda akan langsung dialihkan ke halaman "Dashboard Pekerja: Tugas/Proyek".',
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = '{{route('dashboard.pekerja.proyek')}}';
                }
            });
            @endif
        });

        // $btn.on({
        //     mouseenter: function () {
        //         $(this).removeClass('ld ld-breath');
        //     },
        //     mouseleave: function () {
        //         $(this).addClass('ld ld-breath');
        //     }
        // });

        $btn.on('click', function () {
            @auth
            @if(Auth::user()->isOther())
            @if($user->id == Auth::id())
            swal('PERHATIAN!', 'Maaf, Anda tidak bisa mengajukan bid untuk tugas/proyek Anda sendiri.', 'warning');
            @else
                $("#modal_nego").modal("show");
            {{--swal({--}}
            {{--    title: 'Konfirmasi bid proyek',--}}
            {{--    text: 'Apakah Anda yakin akan mengajukan bid untuk tugas/proyek "{{$proyek->judul}}" ' +--}}
            {{--        'yang ditawarkan oleh "{{$user->name}}"? Anda tidak dapat mengembalikannya!',--}}
            {{--    icon: '{{asset('images/red-icon.png')}}',--}}
            {{--    dangerMode: true,--}}
            {{--    buttons: ["Tidak", "Ya"],--}}
            {{--    closeOnEsc: false,--}}
            {{--    closeOnClickOutside: false,--}}
            {{--}).then((confirm) => {--}}
            {{--    if (confirm) {--}}
            {{--        swal({icon: "success", buttons: false});--}}
            {{--        window.location.href = '{{route('bid.proyek',['username' => $user->username, 'judul' => $proyek->permalink])}}';--}}
            {{--    }--}}
            {{--});--}}
            @endif
            @else
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Klien/Pekerja.', 'warning');
            @endif
            @else
            openLoginModal();
            @endauth
        });

        $submitNego.on('click', function () {
            swal({
                title: 'Konfirmasi bid proyek',
                text: 'Apakah Anda yakin akan mengajukan bid untuk tugas/proyek "{{$proyek->judul}}" ' +
                    'yang ditawarkan oleh "{{$user->name}}"? Anda tidak dapat mengembalikannya!',
                icon: '{{asset('images/red-icon.png')}}',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = '{{route('bid.proyek',['username' => $user->username, 'judul' => $proyek->permalink])}}';
                }
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
