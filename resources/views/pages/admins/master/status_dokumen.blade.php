@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Proyek | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Status Dokumen</h1>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Status Dokumen</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <button class="btn btn-info btn-icon icon-left" id="add_dokumen"><i
                                    class="fa fa-plus"></i> Tambah Data
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="project-dt">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>R2</th>
                                    <th>Terima Dokumen</th>
                                    <th>Create Surat</th>
{{--                                    <th>Scan & Kirim ke HO</th>--}}
                                    <th>Perubahan</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>Berkas</th>
                                    <th>Kelengkapan</th>
{{--                                    <th>KK</th>--}}
{{--                                    <th>Akte Lahir/Cerai</th>--}}
{{--                                    <th>Surat Kematian</th>--}}
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($index as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->nik}}</td>
                                        <td>{{$item->name}}
{{--                                            <a id="lihat-kematian-{{$item->id}}"--}}
{{--                                               onclick="lihat_kematian('{{$item->nik}}','{{$item->name}}','{{$item->dept}}'--}}
{{--                                                   ,'{{$item->group}}','{{$item->meninggal}}','{{$item->status_meninggal}}','{{$item->uang_duka}}')">--}}
{{--                                                <u style="color: blue" >{{$item->name}}</u></a>--}}
                                        </td>
                                        <td>{{$item->r2}}</td>
                                        <td>{{$item->created_at->formatLocalized('%d %B %Y')}}</td>
{{--                                        <td>{{$item->created_at->formatLocalized('%d %B %Y')}}</td>--}}
                                        <td>{{$item->created_at->formatLocalized('%d %B %Y')}}</td>
                                        <td>{{$item->created_at->formatLocalized('%d %B %Y')}}</td>
                                        <td>Rp{{number_format($item->nominal,2,',','.')}}</td>
                                        <td class="text-center">{{$item->keterangan}}
                                        </td>
                                        <td>
                                            @if(!is_null($item->berkas))
                                                <a href="{{asset('storage/dokumen/'. $item->berkas)}}"
                                                   target="_blank">{{$item->berkas}}</a>
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->selesai == 2)
                                                <div class="badge badge-success">Berkas Lengkap</div>
                                            @else
                                                <div class="badge badge-danger">Belum Lengkap</div>
                                            @endif
                                        </td>
{{--                                        <td>--}}
{{--                                            @if(!is_null($item->akte))--}}
{{--                                                <a href="{{asset('storage/dokumen/akte/'. $item->akte)}}"--}}
{{--                                                   target="_blank">{{$item->akte}}</a>--}}
{{--                                            @else--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if(!is_null($item->kk))--}}
{{--                                                <a href="{{asset('storage/dokumen/kk/'. $item->kk)}}"--}}
{{--                                                   target="_blank">{{$item->kk}}</a>--}}
{{--                                            @else--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if(!is_null($item->surat_kematian))--}}
{{--                                                <a href="{{asset('storage/dokumen/surat/'. $item->surat_kematian)}}"--}}
{{--                                                   target="_blank">{{$item->surat_kematian}}</a>--}}
{{--                                            @else--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                        <td>
                                            <form id="delete-form-{{$item->id}}"
                                                  action="{{ route('admin.show.status_dokumen.delete',['id' => $item->id])}}"
                                                  method="POST"
                                                  style="display: none;">

                                                @csrf
                                            </form>
                                            <button class="btn btn-info btn-icon"
                                                    id="edit-dokumen-{{$item->id}}"
                                                    onclick="edit_dokumen('{{$item->id}}','{{$item->user_id}}','{{$item->nik}}','{{$item->name}}','{{$item->kategori_id}}'
                                                        ,'{{$item->r2}}','{{$item->nominal}}','{{$item->terbilang}}','{{$item->keterangan}}','{{$item->berkas}}', '{{$item->selesai}}')">
                                                <i
                                                    class="fa fa-edit"></i></button>
                                            <button class="btn btn-icon" style="color: white;background-color: grey"
                                                    onclick="del({{$item->id}})"><i
                                                    class="fa fa-trash"></i></button>
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
        <form class="modal-part" id="modal-login-part" enctype="multipart/form-data">
            @CSRF
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-id-card"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="nik" name="nik" required>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-font"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Nama" name="name" required>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                    <select name="kategori_id" id="pribadi"
                            class="form-control use-select2" required>
                        <option disabled selected>Pilih Kategori</option>
                        @foreach($kategori as $row)
                        <option value="{{$row->id}}">{{$row->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-user-times"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="R2" name="r2" required>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-money-bill-wave-alt"></i>
                        </div>
                    </div>
                    <input class="form-control rupiah"
                           name="nominal"
                           type="text" placeholder="Rp. "
                           onkeypress="return numberOnly(event, false)"
                    >
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-user-times"></i>
                        </div>
                    </div>
                    <input style="text-transform:uppercase" type="text" class="form-control" placeholder="Terbilang" name="terbilang">
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-user-times"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-ring"></i>
                        </div>
                    </div>
                    <div>
                        <input class="form-control" type="file" name="berkas" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"
                               id="attach-lampiran" style="display: none;">
                        <div class="input-group">
                            <input type="text" id="txt_lampiran"
                                   name="file"
                                   style="cursor: pointer"
                                   class="form-control browse_lampiran" readonly
                                   placeholder="Upload File" data-toggle="tooltip"
                                   data-placement="top"
                                   title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">
                        </div>
                    </div>
                </div>
{{--                <br>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="custom-checkbox custom-control">--}}
{{--                        <input type="checkbox"--}}
{{--                               class="custom-control-input"--}}
{{--                               name="selesai" value="1">--}}
{{--                        <label class="custom-control-label"--}}
{{--                               style="text-transform: none;">Berkas Lengkap ?--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <i class="fa fa-photo-video"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <input type="file" name="kk" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"--}}
{{--                               id="attach-lampiran2" style="display: none;">--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="text" id="txt_lampiran2"--}}
{{--                                   name="file"--}}
{{--                                   style="cursor: pointer"--}}
{{--                                   class="browse_lampiran2 form-control" readonly--}}
{{--                                   placeholder="Pilih File Kartu Keluarga" data-toggle="tooltip"--}}
{{--                                   data-placement="top"--}}
{{--                                   title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <i class="fa fa-archive"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <input type="file" name="akte" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"--}}
{{--                               id="attach-lampiran3" style="display: none;">--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="text" id="txt_lampiran3"--}}
{{--                                   name="file"--}}
{{--                                   style="cursor: pointer"--}}
{{--                                   class="browse_lampiran3 form-control" readonly--}}
{{--                                   placeholder="Pilih File Akte Lahir/Cerai" data-toggle="tooltip"--}}
{{--                                   data-placement="top"--}}
{{--                                   title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <i class="fa fa-book-dead"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <input type="file" name="surat_kematian" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"--}}
{{--                               id="attach-lampiran4" style="display: none;">--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="text" id="txt_lampiran4"--}}
{{--                                   name="file"--}}
{{--                                   style="cursor: pointer"--}}
{{--                                   class="browse_lampiran4 form-control" readonly--}}
{{--                                   placeholder="Pilih File Surat Kematian" data-toggle="tooltip"--}}
{{--                                   data-placement="top"--}}
{{--                                   title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br>--}}
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('admins/js/page/modules-datatables.js')}}"></script>

    <script !src="">

        var export_pesanan = 'Daftar Project tersedia Pertanggal ({{now()->format('j F Y')}})';
        $("#project-dt").DataTable({
            dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "emptyTable": "Anda belum memesan layanan apapun",
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    className: 'btn btn-primary',
                    title: export_pesanan,
                    extension: '.xls'
                }, {
                    text: '<b class="text-uppercase"><i class="fa fa-file-pdf mr-2"></i>PDF</b>',
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    className: 'btn btn-primary',
                    title: export_pesanan,
                    extension: '.pdf'
                }, {
                    text: '<b class="text-uppercase"><i class="fa fa-print mr-2"></i>Cetak</b>',
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    className: 'btn btn-primary'
                }
            ],
            fnDrawCallback: function (oSettings) {
                $('.use-nicescroll').getNiceScroll().resize();
                $('[data-toggle="tooltip"]').tooltip();
            },
        });
        $("#add_dokumen").fireModal({
            title: 'Form Tambah Data Status Dokumen',
            body: $("#modal-login-part"),
            footerClass: 'bg-whitesmoke',
            autoFocus: false,
            onFormSubmit: function (modal, e, form) {
                // Form Data
                var form_data = new FormData(e.target);
                console.log(new FormData(e.target));

                // DO AJAX HERE
                let fake_ajax = setTimeout(function () {
                    // form.stopProgress();
                    // modal.find('.modal-body').prepend('<div class="alert alert-info">Please check your browser console</div>')
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.show.status_dokumen.store')}}",
                        data: form_data, //
                        processData: false,
                        contentType: false,// serializes the form's elements.
                        success: function (data) {
                            console.log(data);
                            form.stopProgress();
                            modal.find('.modal-body').prepend('<div class="alert alert-success">Data successfully added</div>')
                            setTimeout(function () {// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1500);
                            // alert(data); // show response from the php script.
                        },
                        error: function (data) {
                            console.log(data);
                            form.stopProgress();
                            modal.find('.modal-body').prepend('<div class="alert alert-danger">Something wrong please try again later</div>')
                            // alert(data);
                        }
                    });



                    clearInterval(fake_ajax);
                }, 1500);

                e.preventDefault();
            },
            shown: function (modal, form) {
                console.log(form)
            },
            buttons: [
                {
                    text: 'Submit',
                    submit: true,
                    class: 'btn btn-primary btn-shadow',
                    handler: function (modal) {
                    }
                }
            ]
        });
        function update_dokumen() {
            $('#modal-edit-dokumen').ajaxSubmit({
                success: function (data) {
                    $("#updateDokumenModal").modal('hide');
                    console.log(data);
                    swal("Data Berhasil Diperbarui", {
                        icon: "success",
                    });
                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);
                },
                error: function (xhr,modal) {
                    $('#result-code').text(xhr.status);
                    modal.find('.modal-body').prepend('<div class="alert alert-danger">Data successfully added</div>')
                }
                // error: function (data, modal) {
                //     console.log(data);
                //     modal.find('.modal-body').prepend('<div class="alert alert-danger">Something wrong please try again later</div>')
                //     // alert(data);
                // }
            });
        }

        function lihat_dokumen(id, user_id, nik, name, kategori_id, r2, nominal,terbilang, keterangan, berkas) {
            $("#lihatDokumen").modal('show');
            $("#keyid").val(id);
            $("#key_user_id").val(user_id);
            $("#key_lihat").val(nik);
            $("#name_lihat").val(name);
            $("#kategori_lihat").val(kategori_id);
            $("#r2_lihat").val(r2);
            $("#nominal_lihat").val(nominal);
            $("#terbilang_lihat").val(terbilang);
            $("#keterangan_lihat").val(keterangan);
            $("#berkas_lihat").val(berkas);

        }
        function edit_dokumen(id, user_id, nik, name, kategori_id, r2, nominal, terbilang, keterangan, berkas, selesai) {
            $("#updateDokumenModal").modal('show');
            $("#keyid").val(id);
            $("#key_user_id").val(id);
            $("#key_dokumen").val(nik);
            $("#name_dokumen").val(name);
            $("#kategori_id_edit").val(kategori_id);
            $("#r2_edit").val(r2);
            $("#nominal_edit").val(nominal);
            $("#terbilang_edit").val(terbilang);
            $("#keterangan_edit").val(keterangan);
            $("#berkas_edit").val(berkas);
            $("#selesai_id_edit").val(selesai);
            // if (selesai == '1') {
            //     $("#cb-selesai").prop('checked', true);
            // } else {
            //     $("#cb-selesai").prop('checked', false);
            // }
        }
        function del(id) {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang akan dihapus tidak akan bisa dipulihkan lagi!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#delete-form-' + id).ajaxSubmit({
                            success: function (data) {
                                swal("Poof! Data Berhasil Dihapus!", {
                                    icon: "success",
                                });
                                setTimeout(function () {// wait for 5 secs(2)
                                    location.reload(); // then reload the page.(3)
                                }, 1500);
                            },
                            error: function (xhr) {
                                $('#result-code').text(xhr.status);
                            }
                        });

                    } else {
                        swal("Data Tidak Jadi Dihappus!");
                    }
                });
        }
        $(".browse_lampiran").on('click', function () {
            $("#attach-lampiran").trigger('click');
        });

        $("#attach-lampiran").on('change', function () {
            var surat = $(this).prop("files"), names = $.map(surat, function (val) {
                return val.name;
            });
            $("#txt_lampiran").val(names);
            $("#txt_lampiran[data-toggle=tooltip]").attr('data-original-title', names);
        });
    //
    //     $(".browse_lampiran2").on('click', function () {
    //         $("#attach-lampiran2").trigger('click');
    //     });
    //
    //     $("#attach-lampiran2").on('change', function () {
    //         var surat = $(this).prop("files"), names = $.map(surat, function (val) {
    //             return val.name;
    //         });
    //         $("#txt_lampiran2").val(names);
    //         $("#txt_lampiran2[data-toggle=tooltip]").attr('data-original-title', names);
    //     });
    // //
    //     $(".browse_lampiran3").on('click', function () {
    //         $("#attach-lampiran3").trigger('click');
    //     });
    //
    //     $("#attach-lampiran3").on('change', function () {
    //         var surat = $(this).prop("files"), names = $.map(surat, function (val) {
    //             return val.name;
    //         });
    //         $("#txt_lampiran3").val(names);
    //         $("#txt_lampiran3[data-toggle=tooltip]").attr('data-original-title', names);
    //     });
    // //
    //     $(".browse_lampiran4").on('click', function () {
    //         $("#attach-lampiran4").trigger('click');
    //     });
    //
    //     $("#attach-lampiran4").on('change', function () {
    //         var surat = $(this).prop("files"), names = $.map(surat, function (val) {
    //             return val.name;
    //         });
    //         $("#txt_lampiran4").val(names);
    //         $("#txt_lampiran4[data-toggle=tooltip]").attr('data-original-title', names);
    //     });
    </script>
@endpush
