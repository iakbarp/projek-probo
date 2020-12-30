@extends('layouts.mst')
@section('title', 'Bid Tugas/Proyek: '.$proyek->judul.' – '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.bootstrap.min.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .no-striped tbody tr:nth-of-type(odd) {
            background-color: unset;
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
    </style>
@endpush
@section('content')
    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card">
                        <div class="img-card">
                            <img style="width: 100%" alt="Avatar" src="{{$user->get_bio->foto == "" ?
                            asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') : asset('storage/users/foto/'.$user->get_bio->foto)}}">
                        </div>
                        <div class="card-content">
                            <div class="card-title text-center">
                                <a href="{{route('user.profil')}}"><h4 style="color: #122752">{{$user->name}}</h4></a>
                                <small style="text-transform: none">{{$user->get_bio->status != "" ?
                                $user->get_bio->status : 'Status (-)'}}</small>
                            </div>
                            <div class="card-title">
                                <a href="{{route('profil.user', ['username' => $user->username])}}"
                                   class="btn btn-link btn-sm btn-block">Lihat Mode Publik
                                </a>
                                <hr style="margin: 10px 0">
                                <table class="stats" style="font-size: 14px; margin-top: 0">
                                    <tr data-toggle="tooltip" data-placement="left" title="Bergabung Sejak">
                                        <td><i class="fa fa-calendar-check"></i></td>
                                        <td>&nbsp;</td>
                                        <td>{{$user->created_at->formatLocalized('%d %B %Y')}}</td>
                                    </tr>
                                    <tr data-toggle="tooltip" data-placement="left" title="Update Terakhir">
                                        <td><i class="fa fa-clock"></i></td>
                                        <td>&nbsp;</td>
                                        <td style="text-transform: none;">{{$user->updated_at->diffForHumans()}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <div role="tabpanel" class="tab-pane fade in active" id="proyek"
                         aria-labelledby="proyek-tab" style="border: none">
                        <div class="table-responsive">
                            <table class="table table-striped" id="dt-bid">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Bidder</th>
                                    <th class="text-center" style="width: 55px">Harga</th>
                                    <th class="text-center" style="width: 55px">Waktu</th>
                                    <th class="text-center" style="width: 55px">Fitur</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                @foreach($bid as $row)
                                    @php
                                        $proyek->get_proyek;
                                        $pekerja = $row->get_user;
                                        $ulasan_pekerja = \App\Model\ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($pekerja) {
                                            $q->where('user_id', $pekerja->id);
                                        })->get();
                                        $ulasan_layanan = \App\Model\UlasanService::whereHas('get_pengerjaan', function ($q) use ($pekerja) {
                                            $q->where('user_id', $pekerja->id);
                                        })->count();
                                        $rating_pekerja = count($ulasan_pekerja) + $ulasan_layanan > 0 ?
                                            $pekerja->get_bio->total_bintang_pekerja / (count($ulasan_pekerja) + $ulasan_layanan) : 0;

                                        if(!is_null($row->tolak)) {
                                            if($row->tolak == true) {
                                                $class = 'danger';
                                                $status = 'DITOLAK';
                                            } else {
                                                $class = 'success';
                                                $status = 'DITERIMA';
                                            }
                                            $attr = 'disabled';
                                        } else {
                                            $class = 'default';
                                            $status = 'MENUNGGU KONFIRMASI';
                                            $attr = '';
                                        }
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                        <td style="vertical-align: middle">
                                            <div class="row mb-1" style="border-bottom: 1px solid #eee">
                                                <div class="col-md-12">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <a href="{{route('profil.user', ['username' => $pekerja->username])}}">
                                                                <img width="48" class="media-object img-thumbnail"
                                                                     src="{{$pekerja->get_bio->foto == "" ?
                                                                     asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                                                     asset('storage/users/foto/'.$pekerja->get_bio->foto)}}"
                                                                     style="border-radius: 100%">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="media-heading">
                                                                <i class="fa fa-hard-hat mr-2"
                                                                   style="color: #4d4d4d"></i>
                                                                <a href="{{route('profil.user', ['username' => $pekerja->username])}}">
                                                                    {{$pekerja->name}} <sub>{{$pekerja->username}}</sub>
                                                                </a>
                                                            </p>
                                                            <blockquote>
                                                                {!! !is_null($pekerja->get_bio->summary) ? $pekerja->get_bio->summary :
                                                                $pekerja->name.' belum menuliskan apapun di profilnya.' !!}
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="no-striped" style="font-size: 14px;">
                                                        <tr>
                                                            <td><i class="fa fa-envelope"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td style="text-transform: none">
                                                                <a href="mailto:{{$pekerja->email}}">{{$pekerja->email}}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-phone"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                @if($pekerja->get_bio->hp != "")
                                                                    <a href="{{$pekerja->get_bio->hp}}" target="_blank"
                                                                       style="text-transform: none">{{$pekerja->get_bio->hp}}</a>
                                                                @else
                                                                    No. HP/Telp. (-)
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-map-marker-alt"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                @if($pekerja->get_bio->kota_id != "" && $pekerja->get_bio->kewarganegaraan != "")
                                                                    {{$pekerja->get_bio->get_kota->nama.', '.$pekerja->get_bio->get_kota->get_provinsi->nama.', '.$pekerja->get_bio->kewarganegaraan}}
                                                                @else
                                                                    Kabupaten/Kota, Provinsi (-)
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-home"></i></td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                @if($pekerja->get_bio->alamat != "" && $pekerja->get_bio->kode_pos != "")
                                                                    {{$pekerja->get_bio->alamat.' - '.$pekerja->get_bio->kode_pos}}
                                                                @else
                                                                    Alamat (-)
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <hr style="margin: 10px 0">
                                                    <table class="no-striped" style="font-size: 14px; margin-top: 0">
                                                        <tr>
                                                            <td><i class="fa fa-calendar-check"></i></td>
                                                            <td>&nbsp;Bergabung Sejak</td>
                                                            <td>
                                                                : {{$pekerja->created_at->formatLocalized('%d %B %Y')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-clock"></i></td>
                                                            <td>&nbsp;Update Terakhir</td>
                                                            <td style="text-transform: none;">
                                                                : {{$pekerja->updated_at->diffForHumans()}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle" align="center">
{{--                                            <i class="fa fa-star" style="color: #ffc100;margin: 0 0 0 .5rem"></i>--}}
{{--                                            <b>{{round($rating_pekerja * 2) / 2}}</b>--}}
                                            @if($row->negoharga == NULL)
                                                <b>Rp.{{number_format($proyek->harga,2,',','.')}}</b>
                                            @else
                                            <b>Rp.{{number_format($row->negoharga,2,',','.')}}</b>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" align="center">
                                            @if($row->negowaktu == NULL)
                                                <b>{{$proyek->waktu_pengerjaan}} Hari</b>
                                            @else
                                                <b>{{$row->negowaktu}} Hari</b>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" align="center">
                                            @if($row->task == NULL)
                                                <b>Tidak ada task khusus</b>
                                            @else
                                            <b>{{$row->task}}</b>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" align="center">
                                            <span class="label label-{{$class}}">{{$status}}</span>
                                        </td>
                                        <td style="vertical-align: middle" align="center">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-link btn-sm" data-toggle="tooltip"
                                                       title="Lihat Profil"
                                                       href="{{route('profil.user', ['username' => $pekerja->username])}}">
                                                        <i class="fa fa-hard-hat" style="margin-right:0"></i>
                                                    </a>
                                                    <button class="btn btn-link btn-sm" type="button"
                                                            data-toggle="tooltip" title="Terima Bid" {{$attr}}
                                                            id="btn_kontrak">
                                                        <i class="fa fa-paper-plane" style="margin-right: 0"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal_kontrak">
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
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <div style="background-color: #E1E2DF;width: 525px;height: 250px;overflow: scroll;border: 1px solid black;padding: 2px 40px">
                                        <h2>PERJANJIAN KERJA PROYEK</h2>
                                        <small>{{$proyek->judul}}</small>

                                        <h2>Deskripsi</h2>
                                        Perjanjian dalam pembuatan project ini dibuat serta dilaksanakan dan oleh antara
                                        Project Owner untuk selanjutnya disebut sebagai Pihak Pertama dan Freelancer
                                        untuk selanjutnya disebut sebagai Pihak Kedua. Pihak Pertama adalah pihak yang
                                        menyediakan proyek untuk nantinya dikerjakan oleh Pihak Kedua. Sedangkan Pihak
                                        Kedua adalah pihak yang mengerjakan proyek yang telah disediakan oleh Pihak
                                        Pertama. Para Pihak dengan ini setuju dan sepakat untuk melakukan perjanjian
                                        berdasarkan syarat dan ketentuan sebagai berikut:

                                        <h2>I. HAK DAN KEWAJIBAN PIHAK PERTAMA</h2>
                                        <h3>Hak</h3>
                                        1. Menambahkan atau mengarahkan pihak kedua dalam pengembangan proyek agar dapat
                                        diimplementasikan.
                                        2. Menjadi pemilik atas seluruh proyek yang telah selesai.

                                        <h3>Kewajiban</h3>
                                        1. Memberikan pembayaran sesuai dengan kesepakatan untuk setiap proyek yang
                                        berhasil dikerjakan sesuai dengan minimum requirement dan pengajuan tambahan
                                        yang diajukan oleh pekerja.
                                        2. Memberikan konsultasi dan arahan mengenai pengembangan proyek agar dapat
                                        diimplementasikan.

                                        <h2>I. HAK DAN KEWAJIBAN PIHAK KEDUA</h2>
                                        <h3>Hak</h3>
                                        1. Mendapatkan arahan dan konsultasi dari pihak pertama sebagai project owner.
                                        2. Mendapatkan pembayaran sesuai dengan kesepakatan untuk proyek yang sukses
                                        dikerjakan sesuai dengan kesepakatan.

                                        <h3>Kewajiban</h3>
                                        1. Menyelesaikan proyek sesuai dengan minimum requirement dan kontrak yang telah
                                        dibuat.
                                        2. Mengumpulkan seluruh kelengkapan dari produk proyek yang telah disepakati,
                                        serta source code dan aplikasi yang telah dibuat (jika proyek yang dikerjakan
                                        berupa pengembangan aplikasi).
                                        3. Dilarang menggunakan atau mereproduksi keseluruhan proyek untuk digunakan
                                        kepentingan tanpa persetujuan Project Owner.
                                        4. Mengikuti aturan yang telah dikeluarkan oleh pihak pertama.

                                        <h2>III. KETENTUAN PEMBAYARAN</h2>
                                        Project Owner harus membayar hasil pengerjaan proyek oleh Freelancer sesuai
                                        dengan kesepakatan antara kedua belah pihak yang sudah ditetapkan ketika
                                        menyetujui pelelangan proyek.

                                        <h2>IV. SANKSI</h2>
                                        Sanksi diserahkan seluruhnya sesuai keputusan dari project owner.
                                    </div>
                                    <label for="bid" class="pull-right"
                                           style="text-transform: none">
                                        <input type="checkbox" style="background-color: grey" required>	&nbsp;Ya, Saya setuju dengan kontrak ini
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn2" onclick="terimaBid('{{route('klien.terima.bid',['judul' =>
                                                           $proyek->permalink, 'id' => $row->id])}}',
                                    '{{$pekerja->name}}','{{$proyek->judul}}')"><span style="color: white">Terima Bid</span></button>
                            </div>
                        </form>
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
    <script>
        var $btn = $("#btn_kontrak");
        $btn.on('click', function () {
            $("#modal_kontrak").modal("show");
        });
        $(function () {
            var export_bid = 'Daftar Bid Tugas/Proyek: {{$proyek->judul.' ('.now()->format('j F Y').')'}}';

            $("#dt-bid").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [{"sortable": false, "targets": 4}],
                language: {
                    "emptyTable": "Tidak ada bid untuk tugas/proyek [{{$proyek->judul}}] Anda.",
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
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-link btn-sm assets-export-btn export-xls ttip',
                        title: export_bid,
                        extension: '.xls'
                    }, {
                        text: '<b class="text-uppercase"><i class="fa fa-file-pdf mr-2"></i>PDF</b>',
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-link btn-sm assets-select-btn export-pdf',
                        title: export_bid,
                        extension: '.pdf'
                    }, {
                        text: '<b class="text-uppercase"><i class="fa fa-print mr-2"></i>Cetak</b>',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-link btn-sm assets-select-btn export-print'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();
                },
            });
        });

        function terimaBid(url, name, judul) {
            swal({
                title: 'Terima Bid',
                text: 'Apakah Anda yakin akan membuat ' + name + ' menjadi pekerja untuk tugas/proyek "' + judul + '"? ' +
                    'Anda tidak dapat mengembalikannya!',
                icon: '{{asset('images/red-icon.png')}}',
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

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
        }
    </script>
@endpush
