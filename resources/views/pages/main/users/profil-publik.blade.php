@extends('layouts.mst')
@section('title', 'Profil: '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-tabs-responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/grid-list.css')}}">
    <link rel="stylesheet" href="{{asset('css/list-accordion.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
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

        .note-editor.note-airframe .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-editable,
        .note-editor.note-airframe .note-placeholder, .note-editor.note-frame .note-placeholder {
            padding: 20px 30px;
            text-transform: none;
        }
    </style>
@endpush
@section('content')

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        {{--                                            ld ld-breath--}}
                        <span class="input-group-btn">
                                                <button id="btn_hire" class="btn2" type="button"
                                                        data-toggle="tooltip" style="margin-right: .5em;padding: 10px 40px;border-radius: 15px"
                                                        title="Pekerjakan {{$user->name}} untuk menyelesaikan tugas/proyek privat Anda!">
                                                    <b style="color: white">UNDANG SAYA&nbsp;</b><i style="color:white;" class="fa fa-envelope mr-2"></i></button>
                                                <button id="btn_invite_to_bid" class="btn2" type="button"
                                                        data-toggle="tooltip" style="padding: 10px 40px;border-radius: 15px"
                                                        title="Ajak {{$user->name}} ke salah satu bid tugas/proyek Anda!">
                                                    <b style="color: white">PILIH SAYA&nbsp;</b><i style="color:white;" class="fa fa-paper-plane mr-2"></i></button>
                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                    <!-- personal -->
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
                                        <a href="{{$user->id == Auth::id() ? route('user.profil') : url()->current()}}">
                                            <h4 class="aj_name" style="color: #122752">{{$user->name}}</h4></a>
{{--                                        <small style="text-transform: none">{{$user->get_bio->status--}}
{{--                                        != "" ? $user->get_bio->status : 'Status (-)'}}</small>--}}
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
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        {{--                                        <hr style="margin: 10px 0">--}}
                                        <table style="font-size: 14px;">
                                            <tr>
                                                <td>Tanggal Lahir&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    {{$user->get_bio->tgl_lahir == "" ? '-' :
                                                    \Carbon\Carbon::parse($user->get_bio->tgl_lahir)->format('j F Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Kelamin&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_bio->jenis_kelamin != "" ? $user->get_bio->jenis_kelamin : '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Telepon&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_bio->hp != "" ? $user->get_bio->hp : '-'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Email&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: none">{{$user->email}}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_bio->alamat != "" ? $user->get_bio->alamat : '-'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kota&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_bio->kota_id != "" ? $user->get_bio->get_kota->nama.', '.
                                            $user->get_bio->get_kota->get_provinsi->nama : '-'}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- bahasa -->
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-content">--}}
{{--                                    <div class="card-title">--}}
{{--                                        <small>Bahasa</small>--}}
{{--                                        <hr class="mt-0">--}}
{{--                                        <div style="font-size: 14px; margin-top: 0">--}}
{{--                                            @if(count($bahasa) == 0)--}}
{{--                                                <p>{{$user->name}} belum menambahkan kemampuan berbahasanya, baik bahasa--}}
{{--                                                    daerah maupun bahasa asing.</p>--}}
{{--                                            @else--}}
{{--                                                <div data-scrollbar>--}}
{{--                                                    @foreach($bahasa as $row)--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-lg-12">--}}
{{--                                                                <div class="media">--}}
{{--                                                                    <div class="media-left media-middle"--}}
{{--                                                                         style="width: 25%">--}}
{{--                                                                        <img class="media-object" alt="icon"--}}
{{--                                                                             src="{{asset('images/lang.png')}}">--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="media-body">--}}
{{--                                                                        <p class="media-heading">--}}
{{--                                                                            <i class="fa fa-language"></i>&nbsp;--}}
{{--                                                                            <small--}}
{{--                                                                                style="text-transform: uppercase">{{$row->nama}}</small>--}}
{{--                                                                        </p>--}}
{{--                                                                        <blockquote--}}
{{--                                                                            style="font-size: 12px;text-transform: none">--}}
{{--                                                                            <table--}}
{{--                                                                                style="font-size: 12px;margin-top: 0">--}}
{{--                                                                                <tr data-toggle="tooltip"--}}
{{--                                                                                    title="Tingkatan">--}}
{{--                                                                                    <td>--}}
{{--                                                                                        <i class="fa fa-chart-line"></i>--}}
{{--                                                                                    </td>--}}
{{--                                                                                    <td>&nbsp;</td>--}}
{{--                                                                                    <td align="justify">--}}
{{--                                                                                        {{ucfirst($row->tingkatan)}}--}}
{{--                                                                                    </td>--}}
{{--                                                                                </tr>--}}
{{--                                                                            </table>--}}
{{--                                                                        </blockquote>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <hr class="mt-0">--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- skill -->--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-content">--}}
{{--                                    <div class="card-title">--}}
{{--                                        <small>Skill</small>--}}
{{--                                        <hr class="mt-0">--}}
{{--                                        <div style="font-size: 14px; margin-top: 0">--}}
{{--                                            @if(count($skill) == 0)--}}
{{--                                                <p>{{$user->name}} belum menambahkan skill atau kemampuan yang--}}
{{--                                                    dikuasainya.</p>--}}
{{--                                            @else--}}
{{--                                                <div data-scrollbar>--}}
{{--                                                    @foreach($skill as $row)--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-lg-12">--}}
{{--                                                                <div class="media">--}}
{{--                                                                    <div class="media-left media-middle"--}}
{{--                                                                         style="width: 25%">--}}
{{--                                                                        <img class="media-object" alt="icon"--}}
{{--                                                                             src="{{asset('images/skill.png')}}">--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="media-body">--}}
{{--                                                                        <p class="media-heading">--}}
{{--                                                                            <i class="fa fa-user-secret"></i>&nbsp;--}}
{{--                                                                            <small--}}
{{--                                                                                style="text-transform: uppercase">{{$row->nama}}</small>--}}
{{--                                                                        </p>--}}
{{--                                                                        <blockquote--}}
{{--                                                                            style="font-size: 12px;text-transform: none">--}}
{{--                                                                            <table--}}
{{--                                                                                style="font-size: 12px;margin-top: 0">--}}
{{--                                                                                <tr>--}}
{{--                                                                                    <td>--}}
{{--                                                                                        <i class="fa fa-chart-line"></i>--}}
{{--                                                                                    </td>--}}
{{--                                                                                    <td>&nbsp;</td>--}}
{{--                                                                                    <td align="justify">--}}
{{--                                                                                        {{ucfirst($row->tingkatan)}}--}}
{{--                                                                                    </td>--}}
{{--                                                                                </tr>--}}
{{--                                                                            </table>--}}
{{--                                                                        </blockquote>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <hr class="mt-0">--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <!-- summary -->
                    <div class="row card-data">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <small>Summary</small>
                                        <hr class="mt-0">
                                        <small data-scrollbar style="text-transform: none">
                                            {!!$user->get_bio->summary != "" ? $user->get_bio->summary :
                                            '<p>'.$user->name.' belum menuliskan <em>summary</em> atau ringkasan resumenya.</p>'!!}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- rating -->
{{--                    <div class="row card-data">--}}
{{--                        <!-- rating klien -->--}}
{{--                        <div class="col-lg-6">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-content">--}}
{{--                                    <div class="card-title">--}}
{{--                                        <small>Rating Klien</small>--}}
{{--                                        <hr class="mt-0">--}}
{{--                                        <table style="font-size: 14px; margin-top: 0">--}}
{{--                                            <tr>--}}
{{--                                                <td><i class="fa fa-comments"></i></td>--}}
{{--                                                <td>&nbsp;</td>--}}
{{--                                                <td style="text-transform: none">--}}
{{--                                                    <span style="color: #ffc100">--}}
{{--                                            @if(round($rating_klien * 2) / 2 == 1)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 2)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 3)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 4)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 0.5)--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 1.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 2.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 3.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_klien * 2) / 2 == 4.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                        @else--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @endif </span>--}}
{{--                                                    <b>{{round($rating_klien * 2) / 2}}</b> ({{count($ulasan_klien)}}--}}
{{--                                                    ulasan)--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td><i class="fa fa-trophy"></i></td>--}}
{{--                                                <td>&nbsp;</td>--}}
{{--                                                <td>{{$user->get_bio->total_bintang_klien}} poin--}}
{{--                                                    <span style="text-transform: none">(#{{$user->get_rank_klien().' dari '.$total_user}})</span>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td><i class="fa fa-business-time"></i></td>--}}
{{--                                                <td>&nbsp;</td>--}}
{{--                                                <td>{{$user->get_project->count()}} proyek</td>--}}
{{--                                            </tr>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- rating pekerja -->--}}
{{--                        <div class="col-lg-6">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-content">--}}
{{--                                    <div class="card-title">--}}
{{--                                        <small>Rating Pekerja</small>--}}
{{--                                        <hr class="mt-0">--}}
{{--                                        <table style="font-size: 14px; margin-top: 0">--}}
{{--                                            <tr>--}}
{{--                                                <td><i class="fa fa-comments"></i></td>--}}
{{--                                                <td>&nbsp;</td>--}}
{{--                                                <td style="text-transform: none">--}}
{{--                                                    <span style="color: #ffc100">--}}
{{--                                                        @if(round($rating_pekerja * 2) / 2 == 1)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 2)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 3)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 4)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 0.5)--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 1.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 2.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 3.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @elseif(round($rating_pekerja * 2) / 2 == 4.5)--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star"></i>--}}
{{--                                                            <i class="fa fa-star-half-alt"></i>--}}
{{--                                                        @else--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                            <i class="far fa-star"></i>--}}
{{--                                                        @endif </span>--}}
{{--                                                    <b>{{round($rating_pekerja * 2) / 2}}</b>--}}
{{--                                                    ({{count($ulasan_pekerja)}}--}}
{{--                                                    ulasan)--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td><i class="fa fa-trophy"></i></td>--}}
{{--                                                <td>&nbsp;</td>--}}
{{--                                                <td>{{$user->get_bio->total_bintang_pekerja}} poin--}}
{{--                                                    <span style="text-transform: none">(#{{$user->get_rank_pekerja().' dari '.$total_user}})</span>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td><i class="fa fa-tools"></i></td>--}}
{{--                                                <td>&nbsp;</td>--}}
{{--                                                <td>{{$user->get_service->count()}} layanan</td>--}}
{{--                                            </tr>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- tabs portofolio, proyek, layanan, ulasan klien, ulasan pekerja -->
                    <div class="row card-data">
                        <div class="col-lg-12">
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                    <li role="presentation" class="active">
                                        <a class="nav-item nav-link" href="#proyek" id="proyek-tab" role="tab"
                                           data-toggle="tab" aria-controls="proyek" aria-expanded="true">
                                            <i class="fa fa-tasks mr-2"></i>PROYEK
                                            <span class="badge badge-secondary">{{count($proyek) > 999 ? '999+' :
                                            count($proyek)}}</span></a>
                                    </li>
                                    <li role="presentation" class="next">
                                        <a class="nav-item nav-link" href="#layanan" id="layanan-tab" role="tab"
                                           data-toggle="tab" aria-controls="layanan" aria-expanded="true">
                                            <i class="fa fa-tools mr-2"></i>LAYANAN
                                            <span class="badge badge-secondary">{{count($layanan) > 999 ? '999+' :
                                            count($layanan)}}</span></a>
                                    </li>
                                    <li role="presentation" class="next">
                                        <a class="nav-item nav-link" href="#portofolio" id="portofolio-tab" role="tab"
                                           data-toggle="tab" aria-controls="portofolio" aria-expanded="true">
                                            <i class="fa fa-briefcase mr-2"></i>PORTOFOLIO
                                            <span class="badge badge-secondary">{{count($portofolio) > 999 ? '999+' :
                                            count($portofolio)}}</span></a>
                                    </li>
                                    <li role="presentation" class="next">
                                        <a class="nav-item nav-link" href="#ulasan" id="ulasan-tab"
                                           role="tab" data-toggle="tab" aria-controls="ulasan"
                                           aria-expanded="true"><i class="fa fa-comments mr-2"></i>ULASAN
                                            <span class="badge badge-secondary">{{count($ulasan_klien) +
                                            count($ulasan_pekerja) > 999 ? '999+' : count($ulasan_klien) + count($ulasan_pekerja)}}
                                            </span></a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="proyek"
                                         aria-labelledby="proyek-tab" style="border: none">
                                        @if(count($proyek) > 0)
                                            <div class="row">
                                                @foreach($proyek as $row)
                                                    <div class="list-item">
                                                        <a href="{{route('detail.proyek', ['username' =>
                                                            $user->username, 'judul' => $row->permalink])}}">
                                                            <div class="icon">
                                                                <img alt="Thumbnail" src="{{$row->thumbnail != "" ?
                                                                    asset('storage/proyek/thumbnail/'.$row->thumbnail) :
                                                                    asset('images/slider/beranda-1.jpg')}}">
                                                            </div>
                                                            <div class="list-content">

                                                                <p class="list-price">
                                                                    <span>TOTAL KLIEN : <small style="color: #006cff">1 ORANG</small></span>
                                                                    <span
                                                                        class="list-date"><i
                                                                            class="fa fa-calendar-week"></i>Batas Waktu : {{$row->hari_pengerjaan}} hari</span>
                                                                    <br>
                                                                    <span class="custom-size-7" style="color: black">Rp. {{number_format($row->harga,2,',','.')}}</span>
                                                                    <br><sub class="list-category">Kategori {{$row->get_sub
                                                                        ->get_kategori->nama}}:
                                                                        <span>{{$row->get_sub->nama}}</span>
                                                                    </sub>
                                                                </p>
                                                                {!!\Illuminate\Support\Str::words($row->deskripsi, 10, '...')!!}
                                                            </div>
                                                            <div class="item-arrow">
                                                                <span class="custom-size-7" style="font-size: 20px">{{$row->judul}}</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>{{$user->name}} belum menambahkan tugas/proyeknya.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="layanan"
                                         aria-labelledby="layanan-tab" style="border: none">
                                        @if(count($layanan) > 0)
                                            <div class="row">
                                                @foreach($layanan as $row)
                                                    <div class="list-item">
                                                        <a href="{{route('detail.layanan', ['username' =>
                                                            $user->username, 'judul' => $row->permalink])}}">
                                                            <div class="icon">
                                                                <img alt="Thumbnail" src="{{$row->thumbnail != "" ?
                                                                    asset('storage/layanan/thumbnail/'.$row->thumbnail) :
                                                                    asset('images/slider/beranda-pekerja.jpg')}}">
                                                            </div>
                                                            <div class="list-content">

                                                                <p class="list-price">
                                                                    <span>TOTAL KLIEN : <small style="color: #006cff">1 ORANG</small></span>
                                                                    <span
                                                                        class="list-date"><i
                                                                            class="fa fa-calendar-week"></i>Batas Waktu : {{$row->hari_pengerjaan}} hari</span>
                                                                    <br>
                                                                    <span class="custom-size-7" style="color: black">Rp. {{number_format($row->harga,2,',','.')}}</span>
                                                                    <br><sub class="list-category">Kategori {{$row->get_sub
                                                                        ->get_kategori->nama}}:
                                                                        <span>{{$row->get_sub->nama}}</span>
                                                                    </sub>
                                                                </p>
                                                                <div class="rounded"></div>
                                                                {!!\Illuminate\Support\Str::words($row->deskripsi, 10, '...')!!}
                                                            </div>
                                                            <div class="item-arrow">
                                                                <span class="custom-size-7" style="font-size: 20px">{{$row->judul}}</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>{{$user->name}} belum menambahkan layanannya.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="portofolio"
                                         aria-labelledby="portofolio-tab" style="border: none">
                                        @if(count($portofolio) > 0)
                                            <div class="row" id="lightgallery">
                                                @foreach($portofolio as $row)
                                                    <div data-aos="fade-down" class="col-md-4 item"
                                                         data-src="{{asset('storage/users/portofolio/'.$row->foto)}}"
                                                         data-sub-html="<h4>{{$row->tahun.': '.$row->judul}}</h4><p>{{$row->deskripsi}}</p>">
                                                        <div class="content-area">
                                                            <img src="{{asset('storage/users/portofolio/'.$row->foto)}}"
                                                                 alt="Thumbnail" class="img-responsive">
                                                            <div class="custom-overlay">
                                                                <div class="custom-text">
                                                                    <b>{{$row->tahun}}</b><br>
                                                                    {{\Illuminate\Support\Str::words($row->judul,5,'...')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>{{$user->name}} belum menambahkan portofolionya.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="ulasan"
                                         aria-labelledby="ulasan-tab" style="border: none">
                                        <ul id="accordion" class="static-menu">
                                            <li>
                                                <div class="link">
                                                    <i class="fa fa-chevron-right"></i>SEBAGAI KLIEN
                                                    <span
                                                        class="badge badge-secondary ml-2">{{count($ulasan_klien)}}</span>
                                                </div>
                                                <ul class="sub-menu">
                                                    @if(count($ulasan_klien) > 0)
                                                        @foreach($ulasan_klien as $row)
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
                                                                                <i class="fa fa-hard-hat sub-menu-name mr-2"
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
                                                        <li style="border: none">
                                                            {{$user->name}} belum mendapatkan ulasan sebagai klien.
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                            <li>
                                                <div class="link">
                                                    <i class="fa fa-chevron-right"></i>SEBAGAI PEKERJA
                                                    <span
                                                        class="badge badge-secondary ml-2">{{count($ulasan_pekerja)}}</span>
                                                </div>
                                                <ul class="sub-menu">
                                                    @if(count($ulasan_pekerja) > 0)
                                                        @foreach($ulasan_pekerja as $row)
                                                            <li>
                                                                <a href="{{route('profil.user',['username' => $row->get_user->username])}}">
                                                                    <div class="media">
                                                                        <div class="media-left media-middle">
{{--                                                                            <img src="{{$row->get_user->get_bio->foto--}}
{{--                                                                        == "" ? asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :--}}
{{--                                                                        asset('storage/users/foto/'.$row->get_user->get_bio->foto)}}" width="100%" style="border-radius: 2px">--}}
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
{{--                                                                                <span class="pull-right"--}}
{{--                                                                                      style="color: #999">--}}
{{--                                                                                <i class="fa fa-clock"--}}
{{--                                                                                   style="color: #aaa;margin: 0"></i>--}}
{{--                                                                                {{$row->created_at->diffForHumans()}}--}}
{{--                                                                            </span>--}}
                                                                            </p>
                                                                            <blockquote class="sub-menu-blockquote">
                                                                                {!! $row->deskripsi !!}
{{--                                                                                @foreach($row->get_user->get_project as $pr)--}}
{{--                                                                                    {{$pr->judul}}--}}
{{--                                                                                    @endforeach--}}
                                                                            </blockquote>
                                                                        </div>
                                                                        <div class="media-right media-middle custom-size-7">
                                                                            <span>UI/UX Desain</span>
{{--                                                                            @php--}}
{{--                                                                                $judul =$row->get_user->get_project->pluck('judul');--}}

{{--                                                                            @endphp--}}
{{--                                                                            {{$judul->implode(', ')}}--}}
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li style="border: none">
                                                            {{$user->name}} belum mendapatkan ulasan sebagai pekerja.
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- form hire -->
                    <form class="form-horizontal" role="form" method="POST" id="form-hire" enctype="multipart/form-data"
                          action="{{route('user.hire-me', ['username' => $user->username])}}" style="display: none">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="row card-form">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Hire {{$user->name.' ['.$user->username.']'}}</small>
                                            <hr class="mt-0">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label class="form-control-label" for="subkategori_id">Kategori
                                                        <span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                                        <select id="subkategori_id" class="form-control use-select2"
                                                                name="subkategori_id" required>
                                                            <option></option>
                                                            @foreach($kategori as $row)
                                                                <optgroup label="{{$row->nama}}">
                                                                    @foreach($row->get_sub as $sub)
                                                                        <option
                                                                            value="{{$sub->id}}">{{$sub->nama}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="judul" class="form-control-label">Judul <span
                                                            class="required">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                                                        <input id="judul" type="text" name="judul" class="form-control"
                                                               placeholder="Judul" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="deskripsi" class="form-control-label">Deskripsi
                                                        <span class="required">*</span></label>
                                                    <textarea id="deskripsi" name="deskripsi"
                                                              class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-5">
                                                    <label class="form-control-label" for="waktu_pengerjaan">
                                                        Batas Waktu Pengerjaan <span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar-week"></i></span>
                                                        <input id="waktu_pengerjaan" class="form-control"
                                                               name="waktu_pengerjaan" type="text" placeholder="0"
                                                               onkeypress="return numberOnly(event, false)" required>
                                                        <span class="input-group-addon"><b style="text-transform: none">hari</b></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <label class="form-control-label" for="harga">Harga/Budget Proyek
                                                        <span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><b>Rp</b></span>
                                                        <input id="harga" class="form-control rupiah" name="harga"
                                                               type="text" placeholder="0" required>
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-money-bill-wave-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-5 has-feedback">
                                                    <label for="txt_thumbnail"
                                                           class="form-control-label">Thumbnail</label>
                                                    <input type="file" name="thumbnail" accept="image/*"
                                                           id="attach-thumbnail" style="display: none;">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-image"></i></span>
                                                        <input type="text" id="txt_thumbnail" style="cursor: pointer"
                                                               class="browse_thumbnail form-control" readonly
                                                               placeholder="Pilih File" data-toggle="tooltip"
                                                               data-placement="top"
                                                               title="Ekstensi yang diizinkan: jpg, jpeg, gif, png. Ukuran yang diizinkan: < 2 MB">
                                                        <span class="input-group-btn">
                                                                <button
                                                                    class="browse_thumbnail btn btn-link btn-sm btn-block"
                                                                    type="button" style="border: 1px solid #ccc">
                                                                    <i class="fa fa-search"></i></button>
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="txt_lampiran"
                                                           class="form-control-label">Lampiran</label>
                                                    <input type="file" name="lampiran[]" id="attach-lampiran"
                                                           accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"
                                                           style="display: none;" multiple>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-archive"></i></span>
                                                        <input type="text" id="txt_lampiran" style="cursor: pointer"
                                                               class="browse_lampiran form-control" readonly
                                                               placeholder="Pilih File" data-toggle="tooltip"
                                                               data-placement="top"
                                                               title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">
                                                        <span class="input-group-btn">
                                                                <button
                                                                    class="browse_lampiran btn btn-link btn-sm btn-block"
                                                                    type="button" style="border: 1px solid #ccc">
                                                                    <i class="fa fa-search"></i></button>
                                                            </span>
                                                    </div>
                                                    <span class="help-block">
                                                        <small id="count_lampiran"></small>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button class="btn btn-link btn-block" type="submit">
                                            <i class="fa fa-business-time"></i>&nbsp;BUAT PROYEK PRIVAT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- form invite to bid -->
                    <form class="form-horizontal" role="form" method="POST" id="form-bid" style="display: none"
                          action="{{route('user.invite-to-bid', ['username' => $user->username])}}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="row card-form">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small>Pilih {{$user->name.' ['.$user->username.']'}} Sebagai pekerja proyek anda</small>
                                            <hr class="mt-0">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label class="form-control-label" for="proyek_id">Judul Proyek Anda
                                                        <span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-pen"></i></span>
                                                        <select id="proyek_id" class="form-control" name="proyek_id"
                                                                required>
                                                            <option></option>
                                                            @foreach($auth_proyek as $row)
                                                                @php
                                                                    $cek = \App\Model\Undangan::where('user_id', $user->id)
                                                                    ->where('proyek_id', $row->id)->count();
                                                                @endphp
                                                                <option value="{{$row->id}}" data-image="{{$row->thumbnail != "" ?
                                                                asset('storage/proyek/thumbnail/'.$row->thumbnail) :
                                                                asset('images/slider/beranda-1.jpg')}}"
                                                                    {{$cek > 0 ? 'disabled' : ''}}>
{{--                                                                    {{$row->judul.' [Rp'.number_format($row->harga,2,',','.').']'}}--}}
                                                                    {{$row->judul}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="help-block">
                                                        <strong class="strong-error" style="text-transform: none">
                                                            NB: Anda tidak boleh mengundang pekerja ke dalam bid
                                                            tugas/proyek yang sama!
                                                        </strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn2 btn-sm pull-right"
                                                            style="border: 1px solid #ccc"><span style="color: white">SIMPAN</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="card-read-more">--}}
{{--                                        <button class="btn btn-link btn-block" type="submit">--}}
{{--                                            <i class="fa fa-paper-plane"></i>&nbsp;KIRIM UNDANGAN--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <script>
        $(function () {
            var Accordion = function (el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                var links = this.el.find('.link');
                links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown);
            };

            Accordion.prototype.dropdown = function (e) {
                var $el = e.data.el;
                $this = $(this),
                    $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.sub-menu').not($next).slideUp().parent().removeClass('open');
                }
            };

            var accordion = new Accordion($('#accordion'), false);

            $("#deskripsi").summernote({
                placeholder: 'Deskripsikan tugas/proyek Anda disini...',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $("#proyek_id").select2({
                placeholder: "-- Pilih --",
                allowClear: true,
                width: '100%',
                templateResult: format,
                templateSelection: format,
                escapeMarkup: function (m) {
                    return m;
                }
            });
        });

        function format(option) {
            var optimage = $(option.element).data('image');

            if (!option.id) {
                return option.text;
            }

            if (!optimage) {
                return option.text;
            } else {
                return '<img width="64" alt="thumbnail" src="' + optimage + '" style="padding: 5px">' + option.text;
            }
        }

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

        $("#portofolio-tab").on("shown.bs.tab", function () {
            var portofolio = $("#lightgallery");
            portofolio.masonry({
                itemSelector: '.item'
            });
            portofolio.lightGallery({
                selector: '.item',
                loadYoutubeThumbnail: true,
                youtubeThumbSize: 'default',
            });
        });

        $(".static-menu .sub-menu li a").on({
            mouseenter: function () {
                $(this).parent().css('border-color', '#122752');
            },
            mouseleave: function () {
                $(this).parent().css('border-color', '#eee');
            }
        });

        // $("#btn_hire, #btn_invite_to_bid").on({
        //     mouseenter: function () {
        //         $(this).parent().removeClass('ld ld-breath');
        //     },
        //     mouseleave: function () {
        //         $(this).parent().addClass('ld ld-breath');
        //     }
        // });

        $("#btn_hire").on('click', function () {
            @auth
            @if(Auth::user()->isOther())
            @if($user->id == Auth::id())
            swal('PERHATIAN!', 'Maaf, Anda tidak bisa mempekerjakan diri Anda sendiri.', 'warning');
            @else
            if ($('#form-hire').is(':hidden')) {
                $("#form-hire").toggle(300);
                $(".card-data, #form-bid").hide();
            } else {
                $("#form-hire, #form-bid").hide();
                $(".card-data").toggle(300);
            }
            @endif
            @else
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Klien/Pekerja.', 'warning');
            @endif
            @else
            openLoginModal();
            @endauth
        });

        $("#btn_invite_to_bid").on('click', function () {
            @auth
            @if(Auth::user()->isOther())
            @if($user->id == Auth::id())
            swal('PERHATIAN!', 'Maaf, Anda tidak bisa mengajak diri Anda sendiri ke salah satu bid tugas/proyek Anda.', 'warning');
            @else
                @if(Auth::user()->get_project->count() > 0)
            if ($('#form-bid').is(':hidden')) {
                $("#form-bid").toggle(300);
                $(".card-data, #form-hire").hide();
            } else {
                $("#form-hire, #form-bid").hide();
                $(".card-data").toggle(300);
            }
            @else
            swal('PERHATIAN!', 'Maaf, saat ini Anda tidak mempunyai tugas/proyek yang sedang menerima bid.', 'warning');
            @endif
            @endif
            @else
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Klien/Pekerja.', 'warning');
            @endif
            @else
            openLoginModal();
            @endauth
        });

        $(".browse_thumbnail").on('click', function () {
            $("#attach-thumbnail").trigger('click');
        });

        $("#attach-thumbnail").on('change', function () {
            var thumbnail = $(this).prop("files"), names = $.map(thumbnail, function (val) {
                return val.name;
            });
            $("#txt_thumbnail").val(names);
            $("#txt_thumbnail[data-toggle=tooltip]").attr('data-original-title', names);
        });

        $(".browse_lampiran").on('click', function () {
            $("#attach-lampiran").trigger('click');
        });

        $("#attach-lampiran").on('change', function () {
            var lampiran = $(this).prop("files"), names = $.map(lampiran, function (val) {
                return val.name;
            });
            $("#txt_lampiran").val(names);
            $("#txt_lampiran[data-toggle=tooltip]").attr('data-original-title', names);
            $("#count_lampiran").text($(this).get(0).files.length + " file dipilih!");
        });

        $("#form-hire").on('submit', function (e) {
            e.preventDefault();
            if ($('#deskripsi').summernote('isEmpty')) {
                swal('PERHATIAN!', 'Deskripsi tugas/proyek Anda tidak boleh kosong!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });
    </script>
@endpush
