@extends('layouts.mst')
@section('title', 'Cara Kerja | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-toc/bootstrap-toc.min.css')}}">
    <style>
        nav[data-toggle=toc] {
            margin-top: 30px;
        }

        .affix {
            border: 1px solid #eee;
            max-height: 90%;
            overflow-y: auto;
        }

        .affix-bottom {
            position: absolute;
        }

        nav[data-toggle=toc] .nav > li > a {
            font-size: 16px;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        nav[data-toggle=toc] .nav .nav > li > a {
            font-size: 14px;
            padding: 8px;
        }

        @media (max-width: 768px) {
            nav.affix[data-toggle='toc'] {
                position: static;
            }

            nav[data-toggle=toc] .nav .active .nav {
                display: none;
            }
        }
    </style>
@endpush
@section('content')
    <section class="none-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <nav id="toc" data-spy="affix" data-toggle="toc"></nav>
                </div>
                <div class="col-lg-9">
                    <img class="img-responsive center-block" src="https://cdn.projects.co.id/assets/cartoon300/18177908_xxl_2.png">

                    <h3>Klien</h3>
                    <ol style="text-align: justify">
                        <li><a href="#">Daftar</a></li>
                        <li><a href="#">Posting Tugas/Proyek</a><br>
                            Buat Proyek<br>
                            Isi semua instrumen dengan jelas:<br>
                            <em>Title, Deskripsi, Lama Pengerjaan, Project Class, Publish Budget, serta keahlian yang dibutuhkan.</em><br>
                            (Setiap project yang diposting akan diverifikasi terlebih dahulu oleh admin {{env('APP_NAME')}}) </li>
                        <li> Pilih Pekerja
                            <ul>
                                <li> Periksa tawaran Pekerja, melalui:<br>
                                    <strong>My Account &gt; Show Bid</strong> </li>
                                <li> Pilih Pekerja yang paling memenuhi syarat yang dikehendaki. </li>
                            </ul>
                        </li>
                        <li> Transfer<br>
                            Klien transfer ke rekening escrow {{env('APP_NAME')}}.<br>
                            Sebagai garansi:
                            <br>
                            <ul>
                                <li> Pekerja pasti dibayar ketika pekerjaan telah selesai.</li>
                                <li>Klien menerima hasil kerja sesuai dengan yang diinginkan, atau uang dikembalikan kepada Klien ketika Pekerja tidak dapat menyelesaikan pekerjaannya. </li>
                            </ul>
                        </li>
                        <li> Terima Hasil<br>
                            Klien menerima hasil kerja sesuai dengan yang diinginkan. </li>
                    </ol>

                    <h3>Pekerja</h3>
                    <ol style="text-align: justify">
                        <li> <a class="more" href="#">Daftar</a></li>
                        <li> <a class="more" href="#">Cari Tugas/Proyek</a><br>
                            {{env('APP_NAME')}} memberikan informasi secara real time kepada Pekerja, project yang di posting Klien yang sesuai dengan keahlian Pekerja. </li>
                        <li> Ajukan Penawaran
                            <ul>
                                <li> Ajukan tawaran.<br>
                                    (Penawaran dilakukan secara tertutup)<br>
                                    Lihat pada:<br>
                                    <strong>My Account &gt; My Bid</strong></li>
                                <li> Promosikan diri Anda &amp; Tanyakan secara rinci project yang dimaksud.</li>
                            </ul>
                        </li>
                        <li> Kerjakan dan Upload<br>
                            Semua hasil kerja Pekerja di upload ke {{env('APP_NAME')}}, sebagai perlindungan terhadap hasil kerja Pekerja ketika terjadi perselisihan/arbitrase. </li>
                        <li> Terima Hasil<br>
                            Pekerja mendapatkan bayaran sesuai dengan yang dijanjikan. </li>
                    </ol>

                    <h3>Pekerja (Penjual Produk)</h3>
                    <ol style="text-align: justify">
                        <li><a href="#">Daftar</a></li>
                        <li><a href="#">Unggah Produk</a><br>
                            Add New Produk<br>
                            Lengkapi keterangan produk Anda:<br>
                            <em>Nama Produk, Deskripsi, Deliverable (Upload isi keseluruhan dari produk Anda), Harga.</em></li>
                        <li>Publish Produk<br>
                            Tes produk oleh Tim Tester {{env('APP_NAME')}}.<br>
                            (<em>Sebagai garansi semua produk digital yang dipublish adalah produk yang dapat difungsikan sebagaimana mestinya</em>).</li>
                        <li> Jual Produk <br>
                            Berikan penjelasan kepada buyer secara <strong>cepat</strong> dan <strong>jelas</strong>, terhadap semua pertanyaan yang diajukan buyer.</li>
                        <li> Terima hasil<br>
                            Seller menerima bayaran sesuai harga penjualan. </li>
                    </ol>

                    <h3>Klien (Pembeli Produk)</h3>
                    <ol style="text-align: justify">
                        <li><a href="#">Daftar</a></li>
                        <li><a href="#">Cari Produk</a><br>
                            Cari dan pilih produk digital sesuai kebutuhan, melalui:<br>
                            <a href="#"><strong>Produk</strong></a> </li>
                        <li> Beli Produk
                            <ul>
                                <li> Buyer bisa meminta penjelasan kepada seller, klik tombol<br>
                                    <strong>Chat With Seller</strong></li>
                                <li> Beli prooduk<br>
                                    Klik tombol <strong>Add to Cart</strong></li>
                            </ul>
                        </li>
                        <li> Transfer<br>
                            Buyer mentransfer sejumlah uang sesuai harga produk yang dimaksud ke rekening escrow {{env('APP_NAME')}}. </li>
                        <li> Terima hasil<br>
                            Buyer mendapatkan produk sesuai kebutuhan.</li>
                    </ol>

                    <img class="img-responsive center-block" src="https://cdn.projects.co.id/assets/custom/skema_cara_kerja_003.png">
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/bootstrap-toc/bootstrap-toc.min.js')}}"></script>
    <script>
        $("nav[data-toggle=toc]").affix({
            offset: {
                bottom: function () {
                    return (this.bottom = $('footer').outerHeight(true))
                }
            }
        });

        $(document).on('click', 'a[href^="#"]', function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 500);
        });
    </script>
@endpush
