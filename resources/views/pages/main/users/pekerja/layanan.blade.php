@extends('layouts.mst')
@section('title', 'Dashboard Pekerja: Layanan – '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-tabs-responsive.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-striped a {
            color: #777;
            font-weight: 500;
            transition: all .3s ease;
            text-decoration: none !important;
        }

        .table-striped a:hover, .table-striped a:focus, .table-striped a:active {
            color: #122752;
        }

        .btn-link {
            border: 1px solid #ccc;
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
{{--    <div class="breadcrumbs" style="background-image: url('{{$user->get_bio->latar_belakang != null ?--}}
{{--    asset('storage/users/latar_belakang/'.$user->get_bio->latar_belakang) : asset('images/slider/beranda-pekerja.jpg')}}')">--}}
{{--        <div class="breadcrumbs-overlay"></div>--}}
{{--        <div class="page-title">--}}
{{--            <h2>Dashboard Pekerja: Layanan</h2>--}}
{{--            <p>Halaman ini menampilkan daftar layanan yang Anda sediakan dan juga daftar pengerjaannya.</p>--}}
{{--        </div>--}}
{{--        <ul class="crumb">--}}
{{--            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>--}}
{{--            <li><i class="fa fa-angle-double-right"></i> <a href="#">Dashboard Pekerja</a></li>--}}
{{--            <li><i class="fa fa-angle-double-right"></i> <a href="{{url()->current()}}">Layanan</a></li>--}}
{{--            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Daftar Layanan & Pengerjaan</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card">
                        <br>
                        <div class="img-card image-upload menu-item-has-children avatar">
                            <img class="img-thumbnail" style="width: 50%" alt="Avatar" src="{{$user->get_bio->foto == "" ?
                            asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') : asset('storage/users/foto/'.$user->get_bio->foto)}}">
                        </div>
                        <div class="card-content">
                            <div class="card-title text-center">
                                {{--                                <a href="{{route('user.profil')}}"><h4 style="color: #122752">{{$user->name}}</h4></a>--}}
                                <small style="text-transform: none">{{$user->get_bio->status != "" ?
                                $user->get_bio->status : 'Status (-)'}}</small>
                            </div>
                            <table style="font-size: 14px; margin-top: 0" id="stats_personal_data">
                                <tr>
                                    <td>Nama&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>{{$user->name}}</td>
                                </tr>
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
                                {{--                                                        <tr>--}}
                                {{--                                                            <td><i class="fa fa-globe"></i></td>--}}
                                {{--                                                            <td>&nbsp;</td>--}}
                                {{--                                                            <td style="text-transform: none">--}}
                                {{--                                                                {{$user->get_bio->website != "" ? $user->get_bio->website : 'Website (-)'}}--}}
                                {{--                                                            </td>--}}
                                {{--                                                        </tr>--}}
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
                            <div class="card-title">
                                <a href="{{route('profil.user', ['username' => $user->username])}}" class="btn2 btn-block"><small style="color: white">Tampilan Publik</small>
                                </a>
{{--                                <hr style="margin: 10px 0">--}}
{{--                                <table class="stats" style="font-size: 14px; margin-top: 0">--}}
{{--                                    <tr data-toggle="tooltip" data-placement="left" title="Bergabung Sejak">--}}
{{--                                        <td><i class="fa fa-calendar-check"></i></td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td>{{$user->created_at->formatLocalized('%d %B %Y')}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr data-toggle="tooltip" data-placement="left" title="Update Terakhir">--}}
{{--                                        <td><i class="fa fa-clock"></i></td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td style="text-transform: none;">{{$user->updated_at->diffForHumans()}}</td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                            <li role="presentation" class="active">
                                <a class="nav-item nav-link" href="#layanan" id="layanan-tab" role="tab"
                                   data-toggle="tab" aria-controls="layanan" aria-expanded="true">
                                    <i class="fa fa-th-list mr-2"></i>LAYANAN <span class="badge badge-secondary">
                                        {{count($layanan) > 999 ? '999+' : count($layanan)}}</span></a>
                            </li>
                            <li role="presentation" class="next">
                                <a class="nav-item nav-link" href="#pengerjaan" id="pengerjaan-tab"
                                   role="tab" data-toggle="tab" aria-controls="pengerjaan" aria-expanded="true">
                                    <i class="fa fa-briefcase mr-2"></i>PENGERJAAN
                                    <span
                                        class="badge badge-secondary">{{count($pengerjaan) > 999 ? '999+' : count($pengerjaan)}}</span>
                                </a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="layanan"
                                 aria-labelledby="layanan-tab"
                                 style="border: none">
                                <div class="table-responsive" id="dt-layanan">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Layanan</th>
                                            <th class="text-center">Batas Waktu</th>
                                            <th class="text-right">Harga (Rp)</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($layanan as $row)
                                            @php
                                                if(count($row->get_pengerjaan_layanan) > 0) {
                                                    $class = 'success';
                                                    $status = count($row->get_pengerjaan_layanan).' klien';
                                                } else {
                                                    $class = 'default';
                                                    $status = '0 klien';
                                                }

                                                $cek = \App\Model\PengerjaanLayanan::where('service_id', $row->id)
                                                ->where('selesai', false)->count();
                                                if($cek > 0){
                                                    $attr = 'disabled';
                                                } else {
                                                    $attr = '';
                                                }
                                            @endphp
                                            <tr>
                                                <td style="vertical-align: middle" align="center"><a href="{{route('detail.layanan', ['username' =>
                                                    $row->get_user->username, 'judul' => $row->permalink])}}">
                                                        <img class="img-responsive float-left mr-2" width="160"
                                                             alt="Thumbnail" src="{{$row->thumbnail != "" ?
                                                             asset('storage/layanan/thumbnail/'.$row->thumbnail)
                                                             : asset('images/slider/hello.jpg')}}"></a>
                                                </td>
                                                <td style="vertical-align: middle">
                                                        <span
                                                            class="label label-info">{{$row->get_sub->get_kategori->nama}}</span>
                                                        <br><b>{{$row->judul}}</b>
                                                    </a>
                                                    <br><small>{!! $row->deskripsi !!}</small>

                                                </td>
                                                <td style="vertical-align: middle"
                                                    align="center">{{$row->hari_pengerjaan}} hari
                                                </td>
                                                <td style="vertical-align: middle"
                                                    align="right">{{number_format($row->harga,2,',','.')}}</td>
                                                <td style="vertical-align: middle" align="center">
                                                    <span class="label label-info">{{$status}}</span>
                                                </td>
                                                <td style="vertical-align: middle" align="center">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-link btn-sm" href="{{route('detail.layanan',
                                                            ['username' => $row->get_user->username, 'judul' => $row->permalink])}}"
                                                               data-toggle="tooltip" title="Lihat Layanan">
                                                                <i class="fa fa-info-circle" style="margin-right:0"></i>
                                                            </a>
                                                            <button class="btn btn-link btn-sm" data-toggle="tooltip"
                                                                    title="Sunting Layanan" {{$attr}}
                                                                    onclick="suntingLayanan('{{route('pekerja.sunting.layanan', ['id' => $row->id])}}')">
                                                                <i class="fa fa-edit" style="margin-right: 0"></i>
                                                            </button>
                                                            <button class="btn btn-link btn-sm" data-toggle="tooltip"
                                                                    title="Hapus Layanan" type="button" {{$attr}}
                                                                    onclick="hapusLayanan('{{route("pekerja.hapus.layanan",
                                                                    ["id" => $row->id])}}','{{$row->judul}}')">
                                                                <i class="fa fa-trash-alt" style="margin-right: 0"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <form id="form-layanan" class="form-horizontal" role="form" method="POST"
                                      enctype="multipart/form-data" style="display: none">
                                    @csrf
                                    <div class="card">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="id">
                                        <div class="card-content">
                                            <div class="card-title">
                                                <small></small>
                                                <hr class="mt-0">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label class="form-control-label" for="subkategori_id">Kategori
                                                            <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-tag"></i></span>
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
                                                        <label for="judul2" class="form-control-label">Judul <span
                                                                class="required">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-text-width"></i></span>
                                                            <input id="judul2" type="text" name="judul"
                                                                   class="form-control"
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
                                                    <div class="col-md-4">
                                                        <label class="form-control-label" for="hari_pengerjaan">
                                                            Batas Waktu Pengerjaan <span
                                                                class="required">*</span></label>
                                                        <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar-week"></i></span>
                                                            <input id="hari_pengerjaan" class="form-control"
                                                                   name="hari_pengerjaan" type="text" placeholder="0"
                                                                   onkeypress="return numberOnly(event, false)"
                                                                   required>
                                                            <span class="input-group-addon"><b
                                                                    style="text-transform: none">hari</b></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-control-label" for="harga">Harga Layanan
                                                            <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><b>Rp</b></span>
                                                            <input id="harga" class="form-control rupiah" name="harga"
                                                                   type="text" placeholder="0" required>
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-money-bill-wave-alt"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 has-feedback">
                                                        <label for="txt_thumbnail"
                                                               class="form-control-label">Thumbnail</label>
                                                        <input type="file" name="thumbnail" accept="image/*"
                                                               id="attach-thumbnail" style="display: none;">
                                                        <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-image"></i></span>
                                                            <input type="text" id="txt_thumbnail"
                                                                   style="cursor: pointer"
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

                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-lg-12 pull-right">
                                                        <button type="reset" class="btn btn-link btn-sm pull-right"
                                                                style="border: 1px solid #ccc">BATAL
                                                        </button>
                                                        <button class="btn2 btn-link btn-sm pull-right"
                                                                style="margin-right: .5em; background-color: #247bff">
                                                            <b style="color: white">SIMPAN</b>
                                                        </button>
                                                    </div>
{{--                                                    <div class="col-lg-6">--}}
{{--                                                        <button class="btn btn-link btn-sm pull-right"--}}
{{--                                                                style="border: 1px solid #ccc;color: #333;background: #247bff;--}}
{{--    text-transform: uppercase;--}}
{{--    font-size: 12px;--}}
{{--    display: inline-block;--}}
{{--    -webkit-transform: perspective(1px) translateZ(0);--}}
{{--    transform: perspective(1px) translateZ(0);--}}
{{--    border-radius: 7px;--}}
{{--    font-weight: 500;--}}
{{--    padding: 10px 18px;--}}
{{--    -webkit-transition-property: color;--}}
{{--    transition-property: color;--}}
{{--    -webkit-transition-duration: 0.1s;--}}
{{--    transition-duration: 0.1s;--}}
{{--    text-align: center;">--}}
{{--                                                            <b style="color: white">SIMPAN</b>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>
{{--                                        <div class="card-read-more">--}}
{{--                                            <button class="btn btn-link btn-block">--}}
{{--                                                <i class="fa fa-tools"></i>&nbsp;SIMPAN PERUBAHAN--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
                                    </div>
                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="pengerjaan" aria-labelledby="pengerjaan-tab"
                                 style="border: none">
                                <div class="table-responsive" id="dt-pengerjaan">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Detail</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($pengerjaan as $row)
                                            @php
                                                $klien = $row->get_user;
                                                $ulasan_klien = \App\Model\Review::whereHas('get_project', function ($q) use ($klien) {
                                                    $q->where('user_id', $klien->id);
                                                })->get();
                                                $rating_klien = count($ulasan_klien) > 0 ? $klien->get_bio->total_bintang_klien / count($ulasan_klien) : 0;
                                            @endphp
                                            <tr>
                                                <td style="vertical-align: middle" align="center"></td>
                                                <td style="vertical-align: middle">
                                                    <div class="row mb-1" style="border-bottom: 1px solid #eee;">
                                                        <div class="col-lg-12">
                                                            <a href="{{route('detail.layanan', ['username' =>
                                                            $row->get_service->get_user->username, 'judul' =>
                                                            $row->get_service->permalink])}}">
                                                                <img class="img-responsive float-left mr-2"
                                                                     alt="Thumbnail" width="80"
                                                                     src="{{$row->get_service->thumbnail != "" ?
                                                                     asset('storage/layanan/thumbnail/'.$row->get_service->thumbnail)
                                                                     : asset('images/slider/beranda-pekerja.jpg')}}">
                                                                @if(!is_null($row->get_pembayaran))
                                                                    @if(!is_null($row->get_pembayaran->bukti_pembayaran))
                                                                        @if($row->get_pembayaran->jumlah_pembayaran == $row->get_service->harga)
                                                                            <span
                                                                                class="label label-success">LUNAS</span>
                                                                        @else
                                                                            <span class="label label-default">DP {{round($row
                                                                            ->get_pembayaran->jumlah_pembayaran / $row
                                                                            ->get_service->harga * 100,1)}}%</span>
                                                                        @endif |
                                                                        <span class="label label-{{$row->selesai == false ?
                                                                        'warning' : 'success'}}">{{$row->selesai == false ?
                                                                        'PROSES PENGERJAAN' : 'SELESAI'}}</span>
                                                                    @else
                                                                        <span class="label label-default">MENUNGGU KONFIRMASI</span>
                                                                    @endif
                                                                @else
                                                                    <span
                                                                        class="label label-danger">MENUNGGU PEMBAYARAN</span>
                                                                @endif
                                                                <br><b>{{$row->get_service->judul}}</b>
                                                            </a>
                                                            <p>
                                                                Rp{{number_format($row->get_service->harga,2,',','.')}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1" style="border-bottom: 1px solid #eee">
                                                        <div class="col-lg-12">
                                                            <b>KLIEN</b><br>
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <a href="{{route('profil.user', ['username' => $klien->username])}}">
                                                                        <img width="48" alt=""
                                                                             class="media-object img-thumbnail"
                                                                             src="{{$klien->get_bio->foto == "" ?
                                                                 asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                                                 asset('storage/users/foto/'.$klien->get_bio->foto)}}"
                                                                             style="border-radius: 100%">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-hard-hat mr-2"
                                                                           style="color: #4d4d4d"></i>
                                                                        <a href="{{route('profil.user', ['username' => $klien->username])}}">
                                                                            {{$klien->name}}</a>
                                                                        <i class="fa fa-star"
                                                                           style="color: #ffc100;margin: 0 0 0 .5rem"></i>
                                                                        <b>{{round($rating_klien * 2) / 2}}</b>
                                                                    </p>
                                                                    <blockquote>
                                                                        {!! !is_null($klien->get_bio->summary) ? $klien->get_bio->summary :
                                                                        $klien->name.' belum menuliskan apapun di profilnya.' !!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1" style="border-bottom: 1px solid #eee">
                                                        <div class="col-lg-12">
                                                            <ul class="none-margin">
                                                                <li><b>HASIL PENGERJAAN</b></li>
                                                                <li style="list-style: none">
                                                                    @if($row->file_hasil != "")
                                                                        <div class="row use-lightgallery">
                                                                            @foreach($row->file_hasil as $file)
                                                                                <div class="col-md-3 item"
                                                                                     data-src="{{asset('storage/layanan/hasil/'.$file)}}"
                                                                                     data-sub-html="<h4>{{$row->get_service->judul}}</h4><p>{{$file}}</p>">
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
                                                                        (kosong)
                                                                    @endif
                                                                </li>
                                                                <li><b>TAUTAN</b></li>
                                                                <li style="list-style: none">
                                                                    @if($row->tautan != "")
                                                                        <a href="{{$row->tautan}}"
                                                                           target="_blank">{{$row->tautan}}</a>
                                                                    @else
                                                                        (kosong)
                                                                    @endif
                                                                </li>
{{--                                                                <li><b>Progress Pengerjaan</b></li>--}}
{{--                                                                <li>--}}
{{--                                                                    <div class="progress" style="height: 30px;border-radius: 15px;width: 350px">--}}
{{--                                                                        <div class="progress-bar" role="progressbar" style="width: 50%;background-color: #0077FF;border-radius: 15px" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span style="display: block;margin: auto">50%</span></div>--}}
{{--                                                                    </div>--}}
{{--                                                                </li>--}}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <b>ULASAN KLIEN</b><br>
                                                            <div class="media">
                                                                <div class="media-left media-middle">
                                                                    <a href="{{route('profil.user', ['username' =>
                                                                        $klien->username])}}">
                                                                        <img width="48" alt="avatar" src="{{$row
                                                                        ->get_user->get_bio->foto == "" ?
                                                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                                                        asset('storage/users/foto/'.$klien->get_bio->foto)}}"
                                                                             class="media-object img-thumbnail"
                                                                             style="border-radius: 100%">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <p class="media-heading">
                                                                        <i class="fa fa-user-tie mr-2"
                                                                           style="color: #4d4d4d"></i>
                                                                        <a href="{{route('profil.user',
                                                                            ['username'=> $klien->username])}}">
                                                                            {{$klien->name}}</a>
                                                                        @if(!is_null($row->get_ulasan))
                                                                            <i class="fa fa-star"
                                                                               style="color: #ffc100;margin: 0 0 0 .5rem"></i>
                                                                            <b>{{round($row->get_ulasan->bintang * 2) / 2}}</b>
                                                                            <span class="pull-right"
                                                                                  style="color: #999">
                                                                                <i class="fa fa-clock"
                                                                                   style="color: #aaa;margin: 0"></i>
                                                                                {{$row->get_ulasan->created_at->diffForHumans()}}
                                                                            </span>
                                                                        @endif
                                                                    </p>
                                                                    <blockquote>
                                                                        {!! !is_null($row->get_ulasan) ? $row->get_ulasan->deskripsi : '(kosong)' !!}
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle" align="center">
                                                    <button class="btn btn-link btn-sm" data-toggle="tooltip"
                                                            title="Update Progress"
                                                            onclick="updateHasil('{{$row->id}}',
                                                                '{{$row->tautan}}','{{route('pekerja.update-pengerjaan.layanan', ['id' => $row->id])}}',
                                                                '{{$row->get_service->judul}}')"
                                                        {{is_null($row->get_pembayaran) || (!is_null($row->get_pembayaran) &&
                                                        is_null($row->get_pembayaran->bukti_pembayaran)) ||
                                                        $row->selesai == true ? 'disabled' : ''}}>
                                                        <i class="fa fa-upload" style="margin-right: 0"></i>
                                                    </button>
                                                    <br>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <hr>
                                                            <a class="btn btn-link btn-sm" href="{{route('detail.layanan',
                                                               ['username' => $row->get_service->get_user->username,
                                                               'judul' => $row->get_service->permalink])}}"
                                                               data-toggle="tooltip" title="Lihat Layanan">
                                                                <i class="fa fa-info-circle" style="margin-right:0"></i>
                                                            </a>
                                                            <button class="btn btn-link btn-sm" data-toggle="tooltip"
                                                                    title="Update Hasil"
                                                                    onclick="updateHasil('{{$row->id}}',
                                                                        '{{$row->tautan}}','{{route('pekerja.update-pengerjaan.layanan', ['id' => $row->id])}}',
                                                                        '{{$row->get_service->judul}}')"
                                                                {{is_null($row->get_pembayaran) || (!is_null($row->get_pembayaran) &&
                                                                is_null($row->get_pembayaran->bukti_pembayaran)) ||
                                                                $row->selesai == true ? 'disabled' : ''}}>
                                                                <i class="fa fa-upload" style="margin-right: 0"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div id="update-hasil" style="display: none">
                                    <div class="card">
                                        <form class="form-horizontal" role="form" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <div class="card-content">
                                                <div class="card-title">
                                                    <small id="judul"></small>
                                                    <hr class="mt-0">
                                                    <div class="row form-group has-feedback">
                                                        <div class="col-md-12">
                                                            <label for="txt_file_hasil" class="form-control-label">File
                                                                Hasil
                                                                <span class="required">*</span></label>
                                                            <input type="file" name="file_hasil[]" accept="image/*"
                                                                   id="attach-file_hasil" style="display: none;"
                                                                   multiple>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-archive"></i></span>
                                                                <input type="text" id="txt_file_hasil"
                                                                       style="cursor: pointer"
                                                                       class="browse_file_hasil form-control" readonly
                                                                       placeholder="Pilih File" data-toggle="tooltip"
                                                                       title="Ekstensi yang diizinkan: jpg, jpeg, gif, png. Ukuran yang diizinkan: < 5 MB">
                                                                <span class="input-group-btn">
                                                        <button class="browse_file_hasil btn btn-link btn-sm btn-block"
                                                                type="button" style="border: 1px solid #ccc">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                            </div>
                                                            <span class="help-block"><small
                                                                    id="count_file_hasil"></small></span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12 has-feedback">
                                                            <label for="tautan"
                                                                   class="form-control-label">Tautan</label>
                                                            <input id="tautan" type="text" name="tautan"
                                                                   class="form-control"
                                                                   placeholder="http://example.com">
                                                            <span
                                                                class="glyphicon glyphicon-globe form-control-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-12">
                                                            <button type="reset" class="btn btn-link btn-sm"
                                                                    style="border: 1px solid #ccc">
                                                                <i class="fa fa-undo mr-2"></i>BATAL
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-read-more">
                                                <button class="btn btn-link btn-block">
                                                    <i class="fa fa-upload"></i>&nbsp;SIMPAN PERUBAHAN
                                                </button>
                                            </div>
                                        </form>
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
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/masonry/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <script>
        $(function () {
            var export_layanan = 'Daftar Layanan ({{now()->format('j F Y')}})',
                export_pengerjaan = 'Daftar Pengerjaan Layanan ({{now()->format('j F Y')}})';

            $("#dt-layanan table").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [{"sortable": false, "targets": 5}],
                language: {
                    "emptyTable": "Anda belum menambahkan layanan apapun",
                    "info": "Menampilkan _START_ to _END_ of _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 entri",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "loadingRecords": "Memuat...",
                    "processing": "Mengolah...",
                    "search": "Cari:",
                    "zeroRecords": "Data yang Anda cari tidak ditemukan.",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan kolom dari kecil ke besar (asc)",
                        "sortDescending": ": aktifkan untuk mengurutkan kolom dari besar ke kecil (desc)"
                    }
                },
                buttons: [
                    {
                        text: '<b class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</b>',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        className: 'btn btn-link btn-sm assets-export-btn export-xls ttip',
                        title: export_layanan,
                        extension: '.xls'
                    },
                    {
                        text: '<b class="text-uppercase"><i class="fa fa-plus-circle mr-2"></i>Tambah</b>',
                        className: 'btn btn-link btn-sm btn-tambah'
                    },
                    {
                        text: '<b class="text-uppercase"><i class="fa fa-print mr-2"></i>Cetak</b>',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        className: 'btn btn-link btn-sm assets-select-btn export-print'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

                    $(".btn-tambah").on('click', function () {
                        $("#form-layanan .card-title small").text('Tambah Layanan');
                        $("#subkategori_id").val(null).trigger('change');
                        $("#form-layanan input[name=_method], #form-layanan input[name=id], #judul2, #attach-thumbnail, #txt_thumbnail, #hari_pengerjaan, #harga").val(null);
                        $("#txt_thumbnail[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi yang diizinkan: jpg, jpeg, gif, png. Ukuran yang diizinkan: < 2 MB');
                        $("#deskripsi").summernote('code', null);
                        $("#dt-layanan").hide();
                        $("#form-layanan").show().attr('action', '{{route('pekerja.tambah.layanan')}}');
                    });
                },
            });

            $("#dt-pengerjaan table").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [{"sortable": false, "targets": 2}],
                language: {
                    "emptyTable": "Anda belum memiliki tanggungan pengerjaan layanan apapun",
                    "info": "Menampilkan _START_ to _END_ of _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 entri",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "loadingRecords": "Memuat...",
                    "processing": "Mengolah...",
                    "search": "Cari:",
                    "zeroRecords": "Data yang Anda cari tidak ditemukan.",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan kolom dari kecil ke besar (asc)",
                        "sortDescending": ": aktifkan untuk mengurutkan kolom dari besar ke kecil (desc)"
                    }
                },
                buttons: [
                    {
                        text: '<b class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</b>',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        className: 'btn btn-link btn-sm assets-export-btn export-xls ttip',
                        title: export_pengerjaan,
                        extension: '.xls'
                    }, {
                        text: '<b class="text-uppercase"><i class="fa fa-file-pdf mr-2"></i>PDF</b>',
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        className: 'btn btn-link btn-sm assets-select-btn export-pdf',
                        title: export_pengerjaan,
                        extension: '.pdf'
                    }, {
                        text: '<b class="text-uppercase"><i class="fa fa-print mr-2"></i>Cetak</b>',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        className: 'btn btn-link btn-sm assets-select-btn export-print'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

                    var file_hasil = $(".use-lightgallery");
                    file_hasil.masonry({
                        itemSelector: '.item'
                    });
                    file_hasil.lightGallery({
                        selector: '.item',
                        loadYoutubeThumbnail: true,
                        youtubeThumbSize: 'default',
                    });
                },
            });

            $("#deskripsi").summernote({
                placeholder: 'Tulis deskripsi layanan Anda disini...',
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

            @if(session('pengerjaan'))
            swal('Sukses!', '{{ session('pengerjaan') }}', 'success');
            $("#pengerjaan-tab").click();
            @endif
        });

        function suntingLayanan(data_url) {
            $.get(data_url, function (data) {
                $("#form-layanan .card-title small").html('Sunting Layanan #<b>' + data.judul + '</b>');
                $("#form-layanan input[name=_method]").val('PUT');
                $("#form-layanan input[name=id]").val(data.id);
                $("#subkategori_id").val(data.subkategori_id).trigger('change');
                $("#judul2").val(data.judul);
                $("#txt_thumbnail").val(data.thumbnail);
                $("#hari_pengerjaan").val(data.hari_pengerjaan);
                $("#harga").val(data.harga);
                $("#deskripsi").summernote('code', data.deskripsi);
                $("#dt-layanan").toggle(300);
                $("#form-layanan").toggle(300).attr('action', '{{route('pekerja.update.layanan')}}');

                $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
            });
        }

        $("#form-layanan button[type=reset]").on('click', function () {
            $("#form-layanan .card-title small").text(null);
            $("#subkategori_id").val(null).trigger('change');
            $("#form-layanan input[name=_method], #form-layanan input[name=id], #judul2, #attach-thumbnail, #txt_thumbnail, #hari_pengerjaan, #harga").val(null);
            $("#txt_thumbnail[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi yang diizinkan: jpg, jpeg, gif, png. Ukuran yang diizinkan: < 2 MB');
            $("#deskripsi").summernote('code', null);
            $("#dt-layanan").toggle(300);
            $("#form-layanan").toggle(300).removeAttr('action');

            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
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

        $("#form-layanan").on('submit', function (e) {
            e.preventDefault();
            if ($('#deskripsi').summernote('isEmpty')) {
                swal('PERHATIAN!', 'Deskripsi layanan Anda tidak boleh kosong!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        function hapusLayanan(url, judul) {
            swal({
                title: 'Hapus Layanan',
                text: 'Apakah Anda yakin akan menghapus layanan "' + judul + '"? Anda tidak dapat mengembalikannya!',
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = url;
                }
            });
        }

        function updateHasil(id, tautan, action, judul) {
            $("#judul").text(judul);
            $("#tautan").val(tautan);
            $("#dt-pengerjaan").toggle(300);
            $("#update-hasil").toggle(300);
            $("#update-hasil form").attr('action', action);

            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
        }

        $("#update-hasil button[type=reset]").on('click', function () {
            $("#judul").text(null);
            $("#txt_file_hasil, #attach-file_hasil, #tautan").val(null);
            $("#txt_file_hasil[data-toggle=tooltip]").attr('data-original-title',
                'Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf. Ukuran yang diizinkan: < 5 MB');
            $("#dt-pengerjaan").toggle(300);
            $("#update-hasil").toggle(300);
            $("#update-hasil form").removeAttr('action');

            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
        });

        $("#tautan").on("keyup", function () {
            var $uri = $(this).val().substr(0, 4) != 'http' ? 'http://' + $(this).val() : $(this).val();
            $(this).val($uri);
        });

        $(".browse_file_hasil").on('click', function () {
            $("#attach-file_hasil").trigger('click');
        });

        $("#attach-file_hasil").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            });
            $("#txt_file_hasil").val(names);
            $("#txt_file_hasil[data-toggle=tooltip]").attr('data-original-title', names);
            $("#count_file_hasil").text($(this).get(0).files.length + " file dipilih!");
        });

        $("#update-hasil form").on('submit', function (e) {
            e.preventDefault();
            if (!$("#attach-file_hasil").val()) {
                swal('PERHATIAN!', 'File hasil pengerjaan layanan tidak boleh kosong!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        $("#pengerjaan-tab").on('shown.bs.tab', function () {
            var file_hasil = $(".use-lightgallery");
            file_hasil.masonry({
                itemSelector: '.item'
            });
            file_hasil.lightGallery({
                selector: '.item',
                loadYoutubeThumbnail: true,
                youtubeThumbSize: 'default',
            });
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
