@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Proyek | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Meninggal</h1>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Meninggal</h4>
                    </div>
                    <div class="card-body">
{{--                        <div>--}}
{{--                            <button class="btn btn-info btn-icon icon-left" id="add_kematian"><i--}}
{{--                                    class="fa fa-plus"></i> Tambah Data--}}
{{--                            </button>--}}
{{--                        </div>--}}
                        <div class="table-responsive">
                            <table class="table table-striped" id="project-dt">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Tgl Input</th>
                                    <th>Nama Karyawan</th>
                                    <th>PT</th>
                                    <th>Dept.</th>
                                    <th>Nomor Rekening</th>
                                    <th>Yang Meninggal</th>
                                    <th>Hari</th>
                                    <th>Tgl</th>
                                    <th>Kota</th>
{{--                                    <th>Akte Kematian</th>--}}
                                    <th>Nama Alm.</th>
                                    <th>Nominal</th>
                                    <th>Terbilang</th>
                                    <th>Alm/Almh</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($kematian as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->created_at->formatLocalized('%d %B %Y')}}</td>
{{--                                        <td>--}}
{{--                                            <a id="lihat-kematian-{{$item->id}}"--}}
{{--                                            onclick="lihat_kematian('{{$item->nik}}','{{$item->name}}','{{$item->dept}}'--}}
{{--                                                ,'{{$item->group}}','{{$item->meninggal}}','{{$item->status_meninggal}}','{{$item->uang_duka}}')">--}}
{{--                                                <u style="color: blue" >{{$item->name}}</u></a>--}}
{{--                                        </td>--}}
                                        <td>{{$item->get_dokumen->name}}</td>
                                        <td>{{$item->pt}}</td>
                                        <td>{{$item->dept}}</td>
                                        <td>
                                            @if ($item->bank_id == NULL)

                                            @else
                                                {{$item->get_bank->nama}} - {{$item->rekening}}
                                            @endif
                                        </td>
                                        <td>{{$item->status_meninggal}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->tanggal_lahir)->formatLocalized('%A')}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td>
                                        <td>
                                            @if ($item->kota_id == NULL)

                                                @else
                                            {{$item->get_kota->nama}}
                                                @endif
                                        </td>
                                        <td>{{$item->meninggal}}</td>
                                        <td>Rp{{number_format($item->get_dokumen->nominal,2,',','.')}}</td>
                                        <td>{{$item->get_dokumen->terbilang}}</td>
                                        <td>{{$item->alm}}</td>
{{--                                        <td>--}}
{{--                                            @if(($item->surat_kematian == Null))--}}
{{--                                                <span>Data Belum lengkap</span>--}}
{{--                                                @else--}}
{{--                                            <span style="color: greenAkte">Data lengkap</span>--}}
{{--                                                @endif--}}
{{--                                        </td>--}}
                                        <td>
{{--                                            <form id="delete-form-{{$item->id}}"--}}
{{--                                                  action="{{ route('admin.show.kematian.delete',['id' => $item->id])}}"--}}
{{--                                                  method="POST"--}}
{{--                                                  style="display: none;">--}}

{{--                                                @csrf--}}
{{--                                            </form>--}}
                                            <button class="btn btn-info btn-icon"
                                                    id="edit-kematian-{{$item->id}}"
                                                    onclick="edit_kematian('{{$item->id}}','{{$item->pt}}'
                                                        ,'{{$item->dept}}','{{$item->meninggal}}','{{$item->tanggal_meninggal}}'
                                                        ,'{{$item->status_meninggal}}','{{$item->bank_id}}','{{$item->rekening}}','{{$item->kota_id}}','{{$item->alm}}')">
                                                <i
                                                    class="fa fa-edit"></i></button>
{{--                                            <button class="btn btn-icon" style="color: white;background-color: grey"--}}
{{--                                                    onclick="del({{$item->id}})"><i--}}
{{--                                                    class="fa fa-trash"></i></button>--}}
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
                <label>Nama Kematian</label>
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
                            <i class="fa fa-briefcase"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Departement" name="dept" required>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                    <select name="group" id="pribadi"
                            class="form-control use-select2" required>
                        <option disabled selected>Pilih Group</option>
                        <option value="PT. Ajinomoto">PT. Ajinomoto</option>
                        <option value="PT. Ajinex">PT. Ajinex</option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-user-times"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Nama Orang Meninggal" name="meninggal" required>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <select name="status_meninggal"
                            class="form-control use-select2" required>
                        <option disabled selected>Status Meninggal</option>
                        <option value="Ayah Kandung">Ayah Kandung</option>
                        <option value="Ayah Mertua">Ayah Mertua</option>
                        <option value="Ibu Kandung">Ibu Kandung</option>
                        <option value="Ibu Mertua">Ibu Mertua</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-money-bill-wave-alt"></i>
                        </div>
                    </div>
                    <input class="form-control"
                           name="uang_duka"
                           type="text" placeholder="Rp. "
                           onkeypress="return numberOnly(event, false)"
                           required>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-file"></i>
                        </div>
                    </div>
{{--                    <input type="file" class="form-control" accept="image/*"--}}
{{--                           id="attach-thumbnail" name="lampiran" required>--}}
                    <div>
                        <input type="file" name="surat_kematian" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"
                               id="attach-lampiran" style="display: none;">
                        <div class="input-group">
{{--                                                        <span class="input-group-addon"><i--}}
{{--                                                                class="fa fa-image"></i></span>--}}
                            <input type="text" id="txt_lampiran"
                                   name="file"
                                   style="cursor: pointer"
                                   class="browse_lampiran form-control" readonly
                                   placeholder="Pilih File Surat Kematian" data-toggle="tooltip"
                                   data-placement="top"
                                   title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">
{{--                            <span class="input-group-btn">--}}
{{--                                                                <button--}}
{{--                                                                    class="browse_lampiran btn btn-link btn-sm btn-block"--}}
{{--                                                                    type="button" style="border: 1px solid #ccc">--}}
{{--                                                                    <i class="fa fa-search"></i></button>--}}
{{--                                                            </span>--}}
                        </div>
                    </div>
                </div>
                <br>
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <i class="fa fa-flag"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}{{--                    <input type="file" class="form-control" accept="image/*"--}}
{{--                    --}}{{--                           id="attach-thumbnail" name="lampiran" required>--}}
{{--                    <div>--}}
{{--                        <input type="file" name="akte_kematian" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.odt,.ppt,.pptx"--}}
{{--                               id="attach-akte" style="display: none;">--}}
{{--                        <div class="input-group">--}}
{{--                            --}}{{--                                                        <span class="input-group-addon"><i--}}
{{--                            --}}{{--                                                                class="fa fa-image"></i></span>--}}
{{--                            <input type="text" id="txt_akte"--}}
{{--                                   name="file"--}}
{{--                                   style="cursor: pointer"--}}
{{--                                   class="browse_akte form-control" readonly--}}
{{--                                   placeholder="Pilih File Akte Kematian" data-toggle="tooltip"--}}
{{--                                   data-placement="top"--}}
{{--                                   title="Ekstensi yang diizinkan: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, odt, ppt, pptx. Ukuran yang diizinkan: < 5 MB">--}}
{{--                            --}}{{--                            <span class="input-group-btn">--}}
{{--                            --}}{{--                                                                <button--}}
{{--                            --}}{{--                                                                    class="browse_lampiran btn btn-link btn-sm btn-block"--}}
{{--                            --}}{{--                                                                    type="button" style="border: 1px solid #ccc">--}}
{{--                            --}}{{--                                                                    <i class="fa fa-search"></i></button>--}}
{{--                            --}}{{--                                                            </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('admins/js/page/modules-datatables.js')}}"></script>

    <script !src="">

        var export_pesanan = 'Daftar Projecct tersedia Pertanggal ({{now()->format('j F Y')}})';
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    className: 'btn btn-primary',
                    title: export_pesanan,
                    extension: '.xls'
                }, {
                    text: '<b class="text-uppercase"><i class="fa fa-file-pdf mr-2"></i>PDF</b>',
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    className: 'btn btn-primary',
                    title: export_pesanan,
                    extension: '.pdf'
                }, {
                    text: '<b class="text-uppercase"><i class="fa fa-print mr-2"></i>Cetak</b>',
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    className: 'btn btn-primary'
                }
            ],
            fnDrawCallback: function (oSettings) {
                $('.use-nicescroll').getNiceScroll().resize();
                $('[data-toggle="tooltip"]').tooltip();
            },
        });
        $("#add_kematian").fireModal({
            title: 'Form Data Meninggal',
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
                        url: "{{route('admin.show.kematian.store')}}",
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
        function update_kematian() {
            $('#modal-edit-kematian').ajaxSubmit({
                success: function (data) {
                    $("#updateKematianModal").modal('hide');
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

        function lihat_kematian(id, nik, name, dept, group, meninggal, status_meninggal, uang_duka) {
            $("#lihatKematian").modal('show');
            $("#keyid").val(id);
            $("#key_lihat").val(nik);
            $("#name_lihat").val(name);
            $("#dept_lihat").val(dept);
            $("#group_lihat").val(group);
            $("#meninggal_lihat").val(meninggal);
            $("#status_meninggal_lihat").val(status_meninggal);
            $("#uang_duka_lihat").val(uang_duka);

        }
        function edit_kematian(id, pt, dept, meninggal, tanggal_meninggal, status_meninggal, bank_id, rekening, kota_id, alm) {
            $("#updateKematianModal").modal('show');
            $("#key_id").val(id);
            $("#pt_edit").val(pt);
            $("#dept_edit").val(dept);
            $("#meninggal_edit").val(meninggal);
            $("#tanggal_meninggal_edit").val(tanggal_meninggal);
            $("#status_meninggal_edit").val(status_meninggal);
            $("#bank_id_edit").val(bank_id);
            $("#rekening_edit").val(rekening);
            $("#kota_id_edit").val(kota_id);
            $("#alm_edit").val(alm);

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
        $(".browse_akte").on('click', function () {
            $("#attach-akte").trigger('click');
        });

        $("#attach-akte").on('change', function () {
            var akte = $(this).prop("files"), names = $.map(akte, function (val) {
                return val.name;
            });
            $("#txt_akte").val(names);
            $("#txt_akte[data-toggle=tooltip]").attr('data-original-title', names);
        });
    </script>
@endpush
