@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Proyek | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Menikah</h1>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Menikah</h4>
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
                                    <th>Kota Menikah</th>
                                    <th>Tgl Menikah</th>
                                    <th>Nama Istri</th>
                                    <th>Nominal</th>
                                    <th>Terbilang</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pernikahan as $item)
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
                                        <td>
                                            @if ($item->kota_id == NULL)

                                            @else
                                                {{$item->get_kota->nama}}
                                            @endif
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($item->tanggal_menikah)->formatLocalized('%d %B %Y')}}</td>
                                        <td>{{$item->nama_istri}}</td>
                                        <td>Rp{{number_format($item->get_dokumen->nominal,2,',','.')}}</td>
                                        <td>{{$item->get_dokumen->terbilang}}</td>
                                        <td>
                                            {{--                                            <form id="delete-form-{{$item->id}}"--}}
                                            {{--                                                  action="{{ route('admin.show.kematian.delete',['id' => $item->id])}}"--}}
                                            {{--                                                  method="POST"--}}
                                            {{--                                                  style="display: none;">--}}

                                            {{--                                                @csrf--}}
                                            {{--                                            </form>--}}
                                            <button class="btn btn-info btn-icon"
                                                    id="edit-pernikahan-{{$item->id}}"
                                                    onclick="edit_pernikahan('{{$item->id}}','{{$item->pt}}'
                                                        ,'{{$item->dept}}','{{$item->bank_id}}','{{$item->rekening}}','{{$item->kota_id}}'
                                                        ,'{{$item->tanggal_menikah}}','{{$item->nama_istri}}')">
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
        function update_pernikahan() {
            $('#modal-edit-pernikahan').ajaxSubmit({
                success: function (data) {
                    $("#updatePernikahanModal").modal('hide');
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

        // function lihat_kematian(id, nik, name, dept, group, meninggal, status_meninggal, uang_duka) {
        //     $("#lihatKematian").modal('show');
        //     $("#keyid").val(id);
        //     $("#key_lihat").val(nik);
        //     $("#name_lihat").val(name);
        //     $("#dept_lihat").val(dept);
        //     $("#group_lihat").val(group);
        //     $("#meninggal_lihat").val(meninggal);
        //     $("#status_meninggal_lihat").val(status_meninggal);
        //     $("#uang_duka_lihat").val(uang_duka);
        //
        // }
        function edit_pernikahan(id, pt, dept, bank_id, rekening, kota_id, tanggal_menikah, nama_istri) {
            $("#updatePernikahanModal").modal('show');
            $("#key_idpernikahan").val(id);
            $("#pt_pernikahan").val(pt);
            $("#dept_pernikahan").val(dept);
            $("#bank_id_pernikahan").val(bank_id);
            $("#rekening_pernikahan").val(rekening);
            $("#kota_id_pernikahan").val(kota_id);
            $("#tanggal_pernikahan_edit").val(tanggal_menikah);
            $("#nama_istri_edit").val(nama_istri);

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
