@extends('layouts.mst')
@section('title', 'Dashboard Pekerja: Tugas/Proyek – '.$user->name.' | '.env('APP_TITLE'))
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
                                <a href="{{route('profil.user', ['username' => $user->username])}}"
                                   class="btn btn-sm btn-link btn-block"
                                   style="border: 1px solid #ccc;color: #333;background: #247bff;
    text-transform: uppercase;
    font-size: 12px;
    display: inline-block;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    border-radius: 7px;
    font-weight: 500;
    padding: 10px 18px;
    -webkit-transition-property: color;
    transition-property: color;
    -webkit-transition-duration: 0.1s;
    transition-duration: 0.1s;
    text-align: center;"><small style="color: white">Tampilan Publik</small>
                                </a>
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
                <div class="col-lg-9 col-md-6 col-sm-12 text-center">
                    <div class="card">
                        <div class="card-content">
                            <h3>Progress Pengerjaan</h3>
                            @if(count($progress) == 0)
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-title">
                                            Belum Ada Progress
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach($progress as $row)
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-title">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <img style="width: 15%;height: auto"
                                                             class="img-responsive float-left mr-2"
                                                             alt="Thumbnail"
                                                             src="{{$row->get_pengerjaan->get_project->thumbnail != "" ?
                                                                     asset('storage/proyek/progress/'.$row->get_pengerjaan->get_project->thumbnail)
                                                                     : asset('images/slider/beranda-1.jpg')}}">
                                                        <b style="color: #2878ff;font-size: 25px">{{$row->get_pengerjaan->get_project->judul}}</b>
                                                        <b style="color: black;font-size: 25px">({{$row->get_pengerjaan->get_project->waktu_pengerjaan}}
                                                            &nbsp;HARI)</b>
                                                        <br>
                                                        <b>Rp{{number_format($row->get_pengerjaan->get_project->harga,2,',','.')}}
                                                        </b>
                                                        <br>
                                                        @if(!is_null($row->get_pengerjaan->get_project->get_pembayaran))
                                                            @if(!is_null($row->get_pengerjaan->get_project->get_pembayaran->bukti_pembayaran))
                                                                @if($row->get_pengerjaan->get_project->get_pembayaran->jumlah_pembayaran == $row->get_project->harga)
                                                                    <span
                                                                        class="label label-success">LUNAS</span>
                                                                @else
                                                                    <span class="label label-default">DP {{round($row
                                                                            ->get_pengerjaan->get_project->get_pembayaran->jumlah_pembayaran / $row
                                                                            ->get_pengerjaan->get_project->harga * 100,1)}}%</span>
                                                                @endif |
                                                                <span class="label label-{{$row->get_pengerjaan->get_project->selesai == false ?
                                                                        'warning' : 'success'}}">{{$row->get_pengerjaan->get_project->selesai == false ?
                                                                        'PROSES PENGERJAAN' : 'SELESAI'}}</span>
                                                            @else
                                                                <span class="label label-info"
                                                                      style="border-radius: 12px">MENUNGGU KONFIRMASI</span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="label label-danger">MENUNGGU PEMBAYARAN</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <table class="table" id="dt-progress">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Bukti Pengerjaan</th>
                                                        <th class="text-center">Progress</th>
                                                        <th class="text-center">Tanggal Pengerjaan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $no = 1; @endphp
                                                    <tr>
                                                        <td style="vertical-align: middle"><a
                                                                href="{{asset('storage/proyek/progress/'.$row->bukti_gambar)}}"
                                                                target="_blank"><img
                                                                    class="img-responsive text-center" width="160"
                                                                    alt="Thumbnail" src="{{$row->bukti_gambar != "" ?
                                                         asset('storage/proyek/progress/'.$row->bukti_gambar)
                                                         : asset('images/undangan-1.jpg')}}"></a></td>
                                                        <td style="vertical-align: middle"><span
                                                                class="label label-info">PROGRESS PENGERJAAN #{{$no++}}</span>
                                                            <br>
                                                            <p>{{$row->deskripsi}}</p>
                                                        </td>
                                                        <td style="vertical-align: middle" align="center">
                                                            {{$row->created_at->formatLocalized('%d %B %Y')}}
                                                            <br>
                                                            {{$row->created_at->format('H : i : s')}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        {{--                                            </div>--}}
                                    </div>
                                @endforeach
                            @endif
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
        $('#dt-progress').DataTable({
            columnDefs: [{"sortable": false, "targets": 2}],
            language: {
                "emptyTable": "Anda belum menambahkan progress apapun",
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
    </script>
@endpush
