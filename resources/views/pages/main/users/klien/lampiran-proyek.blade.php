@extends('layouts.mst')
@section('title', 'Lampiran Tugas/Proyek: '.$proyek->judul.' – '.$user->name.' | '.env('APP_TITLE'))
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
    <div class="breadcrumbs" style="background-image: url('{{$user->get_bio->latar_belakang != null ?
    asset('storage/users/latar_belakang/'.$user->get_bio->latar_belakang) : asset('images/slider/beranda-proyek.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Lampiran Tugas/Proyek:<br>{{$proyek->judul}}</h2>
            <p>Halaman ini menampilkan daftar lampiran yang Anda tambah/sisipkan untuk tugas/proyek tersebut.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li><i class="fa fa-angle-double-right"></i> <a href="#">Dashboard Klien</a></li>
            <li><i class="fa fa-angle-double-right"></i> <a href="{{route('dashboard.klien.proyek')}}">
                    Daftar Tugas/Proyek & Pengerjaan</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Daftar Lampiran</a></li>
        </ul>
    </div>

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
                        <div class="table-responsive" id="dt-lampiran">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" class="custom-control-input" id="cb-all">
                                            <label for="cb-all" class="custom-control-label">#</label>
                                        </div>
                                    </th>
                                    <th class="text-center">Lampiran</th>
                                    <th>Nama File</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $no = 1;$x=1; @endphp
                                @foreach($lampiran as $file)
                                    @php
                                        $src2 = asset('storage/proyek/lampiran/' .$file);
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {
                                            $src = asset('storage/proyek/lampiran/' .$file);
                                        } else {
                                            $src = asset('images/files.png');
                                        }
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: middle" align="center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="cb-{{$x++}}"
                                                       class="custom-control-input dt-checkboxes">
                                                <label for="cb-{{$x++}}" class="custom-control-label">{{$no++}}</label>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle" align="center">
                                            <img width="100" alt="lampiran" src="{{$src}}" class="img-responsive">
                                        </td>
                                        <td style="vertical-align: middle">{{$file}}</td>
                                        <td style="vertical-align: middle" align="center">
                                            <a class="btn btn-link btn-sm btn-block" href="{{route('detail.proyek',
                                            ['username' => $user->username, 'judul' => $proyek->permalink])}}"
                                               data-toggle="tooltip" title="Lihat Proyek">
                                                <i class="fa fa-info-circle" style="margin-right:0"></i>
                                            </a>
                                            <hr style="margin: .5em 0">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-link btn-sm" href="{{$src2}}" target="_blank"
                                                       data-toggle="tooltip" title="Lihat/Unduh File">
                                                        <i class="fa fa-download" style="margin-right:0"></i>
                                                    </a>
                                                    <button class="btn btn-link btn-sm" type="button"
                                                            data-toggle="tooltip" title="Hapus Proyek"
                                                            onclick="hapusLampiran('{{route("klien.hapus.lampiran",
                                                            ['judul' => $proyek->permalink, 'file' => $file])}}',
                                                                '{{$file}}','{{$proyek->judul}}')">
                                                        <i class="fa fa-trash-alt" style="margin-right: 0"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <form method="post" id="form-mass"
                                  action="{{route('klien.hapus-massal.lampiran', ['judul' => $proyek->permalink])}}">
                                @csrf
                                <input type="hidden" name="lampiran">
                            </form>
                        </div>

                        <form id="form-lampiran" class="form-horizontal" role="form" method="POST"
                              enctype="multipart/form-data" style="display: none"
                              action="{{route('klien.tambah.lampiran', ['judul' => $proyek->permalink])}}">
                            @csrf
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <small>Tambah Lampiran Baru: {{$proyek->judul}}</small>
                                        <hr class="mt-0">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label for="txt_lampiran"
                                                       class="form-control-label">File Lampiran</label>
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
                                                <span class="help-block" style="text-transform: none;">
                                                        <sub id="count_lampiran"></sub>
                                                    </span>
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
                                        <i class="fa fa-archive"></i>&nbsp;SIMPAN PERUBAHAN
                                    </button>
                                </div>
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
        $(function () {
            var table = $("#dt-lampiran table").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [{"sortable": false, "targets": 3}],
                language: {
                    "emptyTable": "Tidak ada lampiran untuk tugas/proyek [{{$proyek->judul}}] Anda.",
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
                        text: '<b class="text-uppercase"><i class="fa fa-archive mr-2"></i>Tambah</b>',
                        className: 'btn btn-link btn-sm btn-tambah'
                    }, {
                        text: '<b class="text-uppercase"><i class="fa fa-trash-alt archive mr-2"></i>Hapus Massal</b>',
                        className: 'btn btn-link btn-sm btn-hapusMassal'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

                    $(".btn-tambah").on('click', function () {
                        $("#attach-lampiran, #txt_lampiran").val(null);
                        $("#txt_lampiran[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB');
                        $("#dt-lampiran").toggle(300);
                        $("#form-lampiran").toggle(300);
                    });

                    $("#cb-all").on('click', function () {
                        if ($(this).is(":checked")) {
                            $("#dt-lampiran table tbody tr").addClass("terpilih")
                                .find('.dt-checkboxes').prop("checked", true).trigger('change');
                        } else {
                            $("#dt-lampiran table tbody tr").removeClass("terpilih")
                                .find('.dt-checkboxes').prop("checked", false).trigger('change');
                        }
                    });

                    $("#dt-lampiran table tbody tr").on("click", function () {
                        $(this).toggleClass("terpilih");
                        if ($(this).hasClass('terpilih')) {
                            $(this).find('.dt-checkboxes').prop("checked", true).trigger('change');
                        } else {
                            $(this).find('.dt-checkboxes').prop("checked", false).trigger('change');
                        }
                    });

                    $('.dt-checkboxes').on('click', function () {
                        if ($(this).is(':checked')) {
                            $(this).parent().parent().parent().addClass("terpilih");
                        } else {
                            $(this).parent().parent().parent().removeClass("terpilih");
                        }
                    });

                    $('.btn-hapusMassal').on("click", function () {
                        var names = $.map(table.rows('.terpilih').data(), function (item) {
                            return item[2]
                        });
                        $("#form-mass input[name=lampiran]").val(names);

                        if (names.length > 0) {
                            swal({
                                title: 'Hapus Massal Lampiran',
                                text: 'Apakah Anda yakin akan menghapus ' + names.length + ' file dari lampiran ' +
                                    'tugas/proyek "{{$proyek->judul}}" ini? Anda tidak dapat mengembalikannya!',
                                icon: 'warning',
                                dangerMode: true,
                                buttons: ["Tidak", "Ya"],
                                closeOnEsc: false,
                                closeOnClickOutside: false,
                            }).then((confirm) => {
                                if (confirm) {
                                    swal({icon: "success", buttons: false});
                                    $("#form-mass")[0].submit();
                                }
                            });
                        } else {
                            $("#cb-all").prop("checked", false).trigger('change');
                            swal("Error!", "Tidak ada lampiran yang Anda pilih untuk dihapus!", "error");
                        }
                    });
                },
            });
        });

        $("#form-lampiran button[type=reset]").on('click', function () {
            $("#attach-lampiran, #txt_lampiran").val(null);
            $("#txt_lampiran[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB');
            $("#dt-lampiran").toggle(300);
            $("#form-lampiran").toggle(300);

            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
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

        $("#form-lampiran").on('submit', function (e) {
            e.preventDefault();
            if (!$("#attach-lampiran").val()) {
                swal('PERHATIAN!', 'File lampiran tidak boleh kosong!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        function hapusLampiran(url, file, judul) {
            swal({
                title: 'Hapus Lampiran',
                text: 'Apakah Anda yakin akan menghapus "' + file + '" dari lampiran ' +
                    'tugas/proyek "' + judul + '"? Anda tidak dapat mengembalikannya!',
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

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
        }
    </script>
@endpush
