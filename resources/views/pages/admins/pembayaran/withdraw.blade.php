@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Pembayaran Withdraw | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Pembayaran Withdraw</h1>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Pembayaran Withdraw</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="dt-order">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Klien</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Withdraw</th>
                                    <th>Status Withdraw</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($withdraw as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->get_user->name}}</td>
                                        <td>{{$item->jumlah}}</td>
                                        <td>{{$item->created_at->diffForHumans()}}</td>
                                        <td>{{$item->updated_at->diffForHumans()}}</td>
                                        <td>@if($item->konfirmasi == true)
                                                {{--                                                belum lunas--}}
                                                <div class="badge badge-info">Terbayarkan</div>
                                            @else
                                                <div class="badge badge-danger">Belum terbayarkan</div>
                                            @endif
                                        </td>
                                        <th>
                                                @if($item->konfirmasi == 0)
                                                    <button class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                            title="Konfimasi Pembayaran Withdraw"
                                                            onclick="action_modal('{{$item->get_user->get_bio->rekening}}',
                                                                '{{$item->get_user->get_bio->bank}}',
                                                                '{{$item->get_user->get_bio->an}}',
                                                                '{{number_format($item->jumlah)}}','{{$item->id}}')"><i
                                                            class="fa fa-cog"></i></button>

                                                @else
                                                    <button class="btn btn-success btn-icon" data-toggle="tooltip"
                                                            title="Withdraw telah terbayar"
                                                            onclick=""><i
                                                            class="fa fa-check-circle"></i></button>
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

        var export_pesanan = 'Daftar Pembayaran Withdraw Pada Tanggal({{now()->format('j F Y')}})';
        $("#dt-order").DataTable({
            dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "emptyTable": "Belum ada request withdraw",
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

        function action_modal(rekening,bank,an,jumlah,id) {
            $('#rekening_withdraw').val(rekening.toString());
            $('#bank_withdraw').val(bank.toString());
            $('#an_withdraw').val(an.toString());
            $('#jumlah').val(jumlah.toString());
            $('#id_withdraw').val(id.toString());
            $("#modalProsesWithdraw").modal('show');
        }

        function withdraw() {
            $('#modal-withdraw').ajaxSubmit({
                success: function (data) {
                    $("#modalProsesWithdraw").modal('hide');
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
