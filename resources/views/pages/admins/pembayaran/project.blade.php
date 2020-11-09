@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Pembayaran Project | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Pembayaran Project</h1>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Pembayaran Project</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="dt-order">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Proyek</th>
                                    <th>Klien</th>
                                    <th>Pekerja</th>
                                    <th>Status Pengerjaan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($project as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->get_project->judul}}</td>
                                        <td>{{$item->get_project->get_user->name}}</td>
                                        <td>{{$item->get_project->get_pengerjaan->get_user->name}}</td>
                                        <td>@if($item->get_project->get_pengerjaan->selesai == 1)
                                                <div class="badge badge-success"  data-toggle="tooltip"
                                                     title="Pengerjaan Proyek Telah Selesai"><i class="fa fa-check-circle"></i></div>
                                                @else
                                                <div class="badge badge-danger"  data-toggle="tooltip"
                                                     title="Pengerjaan Proyek Belum Selesai"><i class="fa fa-times-circle"></i></div>
                                            @endif</td>
                                        <td>@if($item->jumlah_pembayaran < $item->get_project->harga)
                                                {{--                                                belum lunas--}}
                                                <div class="badge badge-danger">Belum Lunas</div>
                                            @else
                                                <div class="badge badge-info">Lunas</div>
                                            @endif
                                            @if($item->selesai == 0)
                                                <div class="badge badge-warning">Belum Dibayarkan</div>
                                            @else
                                                <div class="badge badge-primary">Telah Dibayarkan</div>
                                            @endif
                                        </td>
                                        <td>{{$item->created_at->diffForHumans()}}</td>
                                        <th>
                                            @if($item->jumlah_pembayaran < $item->get_project->harga)
                                                {{--                                                belum lunas--}}
                                                <button class="btn btn-warning btn-icon" data-toggle="tooltip"
                                                        title="Pembayaran Belum Selesai"
                                                        onclick=""><i
                                                        class="fa fa-info-circle"></i></button>
                                            @else
                                                @if($item->selesai == 0)
                                                    <button class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                              title="Konfimasi Pengelesaian Proyek"
                                                            onclick="action_modal('{{$item->get_project->get_pengerjaan->get_user->get_bio->rekening}}',
                                                                '{{$item->get_project->get_pengerjaan->get_user->get_bio->bank}}',
                                                                '{{$item->get_project->get_pengerjaan->get_user->get_bio->an}}',
                                                                '{{number_format($item->get_project->harga)}}','{{$item->id}}')"><i
                                                            class="fa fa-cog"></i></button>

                                                @else
                                                    <button class="btn btn-success btn-icon" data-toggle="tooltip"
                                                            title="Pekerja Telah Dibayar"
                                                            onclick=""><i
                                                            class="fa fa-check-circle"></i></button>
                                                @endif
                                            @endif
                                        </th>
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

        var export_pesanan = 'Daftar Pembayaran Proyek Pada Tanggal({{now()->format('j F Y')}})';
        $("#dt-order").DataTable({
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

        function action_modal(rekening,bank,an,harga,id) {
            $('#rekening').val(rekening.toString());
            $('#bank').val(bank.toString());
            $('#an').val(an.toString());
            $('#harga').val(harga.toString());
            $('#id_payment').val(id.toString());
            $("#modalProsesProject").modal('show');
        }

        function payment() {
            $('#modal-payment').ajaxSubmit({
                success: function (data) {
                    $("#modalProsesProject").modal('hide');
                    console.log(data);
                    swal("Data Pembayaran Berhasil Diproses", {
                        icon: "success",
                    });
                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);
                },
                error: function (xhr, modal) {
                    $('#result-code').text(xhr.status);
                    modal.find('.modal-body').prepend('<div class="alert alert-danger">Tejadi Kesalahan Silahkan Coba Lagi</div>')
                }
            });
        }
    </script>
@endpush
