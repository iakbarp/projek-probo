@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Layanan | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Layanan</h1>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Layanan</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="service-dt">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Proyek</th>
                                    <th>Pemilik</th>
                                    <th>Kategori Proyek</th>
                                    <th>Deskripsi</th>
                                    <th>Waktu Pengerjaan</th>
                                    <th>Harga Project</th>

                                    <th>Update Terakhir</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($service as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->judul}}</td>
                                        <td>{{$item->get_user->name}}</td>
                                        <td>{{$item->get_sub->nama}}</td>
                                        <td>{!! $item->deskripsi !!}</td>
                                        <td>{{$item->hari_pengerjaan}} Hari</td>
                                        <td>Rp. {{number_format($item->harga)}}</td>

                                        <td>{{$item->updated_at->diffForHumans()}}</td>
                                        <th>
                                            <a href="{{route('detail.layanan',['username' => $item->get_user->username, 'judul' =>
                                                    $item->permalink])}}" target="_blank">
                                                <button class="btn btn-success btn-icon" data-toggle="tooltip"
                                                        title="Lihat di Website"
                                                        onclick=""><i
                                                        class="fa fa-search"></i></button>
                                            </a>
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

    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>

    <script !src="">

        var export_pesanan = 'Daftar Layanan tersedia Pertanggal ({{now()->format('j F Y')}})';
        $("#service-dt").DataTable({
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
    </script>
@endpush
