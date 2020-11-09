@extends('layouts.mst')
@section('title', 'Kebijakan Privasi | '.env('APP_TITLE'))
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
                <div class="col-lg-4">
                    <nav id="toc" data-spy="affix" data-toggle="toc"></nav>
                </div>
                <div class="col-lg-8">
                    <p align="justify">Terima kasih telah menggunakan produk dan layanan {{env('APP_NAME')}} yang
                        beralamat di Pohkecik, Dlanggu, Mojokerto, Jawa Timur — 61371. {{env('APP_NAME')}} bertekad
                        melindungi dan menghargai hak pribadi Anda.
                    </p>
                    <p align="justify"> Kebijakan privasi {{env('APP_NAME')}} dimaksudkan untuk menginformasikan praktek
                        dan kebijakan kami mengenai pengumpulan, penggunaan dan pengungkapan informasi pribadi Anda,
                        juga sebagai acuan untuk mengatur dan melindungi setiap informasi pribadi yang Anda sampaikan
                        pada saat registrasi serta informasi pribadi yang Anda berikan melalui koresponden, chatting
                        ataupun yang berasal dari layanan atau situs lain. &quot;Informasi Pribadi&quot; adalah
                        informasi tentang Anda yang dapat diidentifikasi secara pribadi kepada Anda, seperti nama,
                        alamat tinggal, alamat email, nomor telepon, nomor ponsel, nomor rekening bank, juga informasi
                        aktivitas transaksi Anda di {{env('APP_NAME')}} (seperti penawaran project, pengerjaan project,
                        penjualan serta pembelian produk digital) yang berhubungan dengan akun Anda.</p>
                    <p align="justify"> Adanya kebijakan privasi ini adalah komitmen dan bukti nyata
                        dari {{env('APP_NAME')}} untuk melindungi dan menghargai hak pribadi Anda agar setiap informasi
                        yang Anda sampaikan atau Anda dapatkan terbatas untuk tujuan proses identifikasi, sehingga
                        informasi dimaksud hanya digunakan sesuai dengan kebutuhan identifikasi menurut peraturan yang
                        diberlakukan oleh {{env('APP_NAME')}}.</p>
                    <p align="justify"> Bacalah dengan saksama keterangan di bawah ini untuk memahami pandangan dan
                        kebiasaan kami berkenaan dengan data dan informasi pribadi Anda dan bagaimana kami memperlakukan
                        data dan informasi pribadi Anda.</p>
                    <p align="justify"> Jika Anda tidak merasa menyerahkan identitas ataupun mendaftarkan diri Anda di
                        situs {{env('APP_NAME')}}, namun Anda menerima email ataupun menerima Layanan Pesan Singkat
                        (SMS) kami dan menganggap hal tersebut adalah kekeliruan, Anda dapat memilih untuk tidak
                        menerima informasi dan penawaran-penawaran tersebut (&quot;unsubscribe&quot; atau &quot;opt-out&quot;)
                        dengan cara mengikuti petunjuk yang diberikan dalam pesan SMS ataupun email yang Anda terima.
                        Jika Anda tidak menemukan cara untuk unsubscribe atau opt-out, hubungi kami di <span class="email"><a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a></span>.
                    </p>
                    <p align="justify"> Dengan menggunakan situs {{env('APP_NAME')}} berarti Anda menerima Kebijakan
                        Privasi ini. {{env('APP_NAME')}} berhak untuk mengubah atau memodifikasi kebijakan privasi ini
                        secara keseluruhan atau sebagian dari waktu ke waktu tanpa pemberitahuan terlebih dahulu kepada
                        Anda. Kecuali pemberitahuan sebelumnya tersebut diwajibkan oleh hukum, kami akan mengirimkan
                        pemberitahuan modifikasi material ke alamat email Anda. Revisi ini juga akan diposting di
                        situs {{env('APP_NAME')}}. Versi terbaru dari kebijakan privasi akan efektif diberlakukan pada
                        saat kami posting. Oleh karenanya, Anda wajib untuk memeriksa halaman ini secara berkala dalam
                        rangka untuk mengetahui dan memahami perubahan-perubahan yang disampaikan. Kebijakan privasi ini
                        berlaku efektif sejak 10 November 2014.</p>
                    <p align="justify"> Penggunaan istilah &quot;Kami&quot; atau &quot;{{env('APP_NAME')}}&quot; adalah
                        sebutan untuk menggantikan kata atau sebutan untuk {{env('APP_NAME')}}, afiliasinya dan/atau
                        stafnya.</p>
                    <h3 data-toc-text="Pengumpulan Data dan Informasi Pribadi">Data dan informasi pribadi yang kami kumpulkan </h3>
                    <ul style="text-align: justify">
                        <li>Pada saat pendaftaran sebagai pengguna dan ketika Anda mengunjungi atau menggunakan
                            layanan situs kami;
                        </li>
                        <li>Data dan informasi pribadi, seperti nama, alamat email, tempat dan tanggal lahir, nomor
                            telepon yang dapat dihubungi, password dan informasi atau data lainnya yang diperlukan.
                        </li>
                        <li>Informasi aktivitas berdasarkan transaksi Anda di situs (seperti penawaran project,
                            project yang Anda hasilkan, penjualan ataupun pembelian produk digital) serta informasi
                            lainnya yang berhubungan dengan aktivitas transaksi Anda;
                        </li>
                        <li>Data dan informasi pribadi melalui korespondensi yang Anda lakukan di
                            situs {{env('APP_NAME')}}, koresponden Anda dengan pengguna lainnya ataupun koresponden
                            Anda dengan kami;
                        </li>
                        <li>Data dan informasi pribadi tambahan. Kami mungkin akan meminta Anda untuk mengirimkan
                            dan memverifikasi diri sendiri jika kami mendapati pelanggaran atau kecurigaan terhadap
                            akun Anda (kami akan meminta Anda untuk menjawab pertanyaan tambahan untuk membantu kami
                            memverifikasi identitas Anda).
                        </li>
                    </ul>
                    <h3 data-toc-text="Penggunaan Data dan Informasi Pribadi">Penggunaan data dan informasi pribadi</h3>
                    <ul style="text-align: justify">
                        <li>Informasi yang kami kumpulkan digunakan untuk memperbaiki isi situs web kami, untuk
                            memberitahu Anda tentang update ke situs web kami, untuk komunikasi dan untuk
                            meningkatkan produk dan layanan kami serta memberikan berbagai informasi dan/atau
                            penawaran produk dan layanan lain {{env('APP_NAME')}} maupun layanan pihak ketiga yang
                            bekerja sama dengan {{env('APP_NAME')}} atau PT Panonpoe Media;
                        </li>
                        <li>Kami dapat mengirimkan email kepada Anda untuk memverifikasi akun Anda dan email
                            transaksional lainnya untuk keperluan operasional atau pemeliharaan sistem;
                        </li>
                        <li>Kami dapat mengirimkan email ataupun Layanan Pesan Singkat (SMS) promosi tentang project
                            terbaru, penawaran project, produk digital terbaru, maupun informasi lainnya ke alamat
                            email atau ke nomor ponsel Anda yang telah didaftarkan oleh Anda pada situs kami;
                        </li>
                        <li>Kami dapat menggunakan data dan informasi pribadi yang Anda sampaikan tanpa kecuali
                            untuk melakukan analisa statistik, demografi dan marketing dari para pengguna serta
                            kebiasaan dan pola-pola penggunaan yang terjadi untuk pengembangan produk dan menarik
                            pengiklan terhadap kebiasaan pengguna. Kami juga menggunakan informasi ini untuk
                            memungkinkan iklan yang lebih sesuai target pengguna. {{env('APP_NAME')}} juga dapat
                            berbagi informasi pengguna dengan perusahaan-perusahaan di grup {{env('APP_NAME')}} atau
                            PT Panonpoe Media untuk tujuan analisa, termasuk analisa untuk meningkatkan hubungan
                            pelanggan. Kami mungkin akan menghubungi Anda melalui email, telepon, fax maupun surat
                            berdasarkan data dan informasi yang Anda sampaikan tersebut;
                        </li>
                        <li>Kami terkadang menerima informasi mengenai berbagai promosi dan acara khusus yang
                            diselenggarakan oleh sponsor atau rekanan kami. Untuk itu kami juga menawarkan pada Anda
                            yang ingin diundang pada acara-acara tersebut untuk memberikan informasi yang dibutuhkan
                            pihak penyelenggara dan akan diindikasikan pada waktu pengumpulan.
                        </li>
                        <li>Anda memahami bahwa {{env('APP_NAME')}} dapat meminta dan mendapatkan setiap data dan
                            informasi pribadi Anda demi kesinambungan dan keamanan situs ini;
                        </li>
                        <li>Data dan informasi dalam profil Anda juga tersedia untuk setiap pengguna lain untuk
                            dapat mengakses Anda. Kami tidak memiliki kewajiban dalam kebijakan privasi ini
                            sehubungan dengan data dan informasi dalam profil Anda atau informasi Anda untuk dapat
                            di akses oleh pengguna lain atau juga oleh pihak ketiga melalui situs kami;
                        </li>
                        <li>Apabila di dalam situs kami terdapat berbagai link ke banyak situs lain yang disediakan
                            untuk kenyamanan Anda, kami tidak bertanggung jawab terhadap kebijakan penanganan
                            informasi pribadi di situs-situs tersebut. Seringkali pengunaan produk dan layanan kami
                            mengharuskan kami menyerahkan informasi Anda kepada pihak lain agar transaksi dalam
                            berjalan dengan sempurna, kami juga tidak bertanggung jawab terhadap kebijakan
                            penanganan informasi pribadi di pihak-pihak tersebut. Kami sangat menganjurkan bagi Anda
                            untuk selalu melihat dan mempelajari kebijakan penanganan informasi pribadi di
                            situs-situs dan pihak-pihak tersebut sebelum memberikan informasi pribadi;
                        </li>
                        <li>Kami tidak akan menjual, menyewakan, menukar, atau memberikan wewenang kepada pihak
                            ketiga untuk menggunakan alamat e-mail dan nomor telepon Anda atau informasi lainnya
                            yang secara pribadi bisa mengidentifikasi diri Anda tanpa ijin, kecuali kami menjual
                            atau membeli suatu bisnis atau aset, dimana dalam hal ini kami dapat mengungkapkan data
                            Anda kepada calon penjual atau pembeli dari bisnis atau aset tersebut.
                            Apabila {{env('APP_NAME')}} atau secara substansial semua asetnya diakuisisi oleh pihak
                            ketiga, dimana dalam hal ini, data pribadi yang dimiliki oleh pihaknya mengenai
                            pelanggannya akan menjadi salah satu aset yang dialihkan. Kami juga dapat menyampaikan
                            informasi pribadi jika diperintahkan oleh hukum atau percaya bahwa langkah tersebut
                            adalah perlu dilakukan untuk 1) patuh pada hukum atau proses pengadilan; 2) melindungi
                            dan mempertahankan hak cipta dan hak milik kami; 3) melindungi terhadap penyalahgunaan
                            atau penggunaan tanpa ijin dari situs web kami; atau 4) melindungi keamanan pribadi atau
                            properti atas pengguna kami atau publik (di antara hal lainnya, hal ini berarti jika
                            Anda memberikan informasi palsu atau berpura-pura menjadi orang lain, informasi mengenai
                            diri Anda dapat kami sampaikan sebagai bagian dari penyelidikan atas tindakan Anda).
                            Selain itu kami dapat berbagi informasi tentang pengguna kami dalam bentuk keseluruhan
                            (agregat);
                        </li>
                        <li>Kerahasiaan kata sandi atau password merupakan tanggung jawab masing-masing
                            pengguna. {{env('APP_NAME')}} tidak bertanggung jawab atas kerugian dalam bentuk apapun
                            yang dapat ditimbulkan akibat kelalaian Anda dalam menjaga kerahasiaan password Anda.
                        </li>
                    </ul>
                    <h3>Penyimpanan data dan informasi pribadi</h3>
                    <p align="justify"> Kami akan menyimpan data dan informasi Anda selama akun Anda aktif. Hal ini
                        diperlukan bagi kami untuk menyediakan layanan bagi Anda. Jika Anda ingin membatalkan akun Anda
                        atau meminta kami untuk tidak lagi menggunakan data dan informasi Anda untuk menyediakan
                        layanan, hubungi kami di <span class="email"><a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a></span>.
                        Kami akan menyimpan dan menggunakan informasi Anda yang diperlukan untuk mematuhi kewajiban
                        hukum kami, menegakkan kesepakatan kami dan menyelesaikan sengketa yang mungkin terjadi.</p>
                    <p align="justify"> Setiap data dan informasi pribadi Anda yang disampaikan kepada kami akan kami
                        simpan secara elektronik dengan menggunakan perangkat keamanan teruji di server kami yang
                        berlokasi di pusat data kami di Jacksonville, Florida USA dan di kantor kami yang berlokasi di
                        Bandung, Jawa Barat, Indonesia. Akan tetapi Anda mengerti bahwa semua transmisi data lewat
                        internet dan penyimpanan offline tidaklah sepenuhnya aman. Meskipun kami akan melakukan semua
                        tindakan yang diperlukan untuk melindungi data Anda, kami tidak dapat menjamin data Anda akan
                        sepenuhnya aman. Segala bentuk transmisi data baik online maupun offline adalah resiko Anda dan
                        Anda setuju untuk membebaskan {{env('APP_NAME')}} dan/atau PT Panonpoe Media dari segala bentuk
                        tuntutan hukum.</p>
                    <h3>Alamat IP (Internet Protocol) </h3>
                    <p align="justify">Kami dapat mengumpulkan informasi mengenai komputer atau device yang Anda gunakan
                        untuk mengakses {{env('APP_NAME')}}, menyimpan alamat IP (Internet Protocol), dan/atau lokasi
                        komputer atau device Anda di Internet, untuk keperluan administrasi sistem dan troubleshooting.
                        Kami menggunakan alamat IP secara keseluruhan (agregat) untuk mengetahui lokasi-lokasi pengguna
                        yang mengakses situs kami. Semua ini adalah data statistika mengenai kerja dan pola browsing
                        pengguna kami, dan tidak mengidentifikasi individu manapun. </p>
                    <h3>Cookies </h3>
                    <p align="justify">Cookies adalah file kecil yang secara otomatis akan mengambil tempat di dalam
                        perangkat komputer atau device Anda untuk mengidentifikasi dan memantau koneksi jaringan Anda.
                        Cookies memungkinkan Anda untuk mengakses layanan dari situs kami secara optimal, oleh karena
                        itu kami dapat memperoleh informasi mengenai penggunaan internet Anda secara umum dengan
                        menggunakan file cookies yang disimpan di hard drive komputer atau device Anda. Cookies berisi
                        informasi yang dialihkan ke hard drive komputer atau device Anda. Cookies membantu kami
                        memperbaiki situs kami dan memberikan layanan yang lebih baik dan lebih sesuai dengan selera
                        Anda. <br/>
                        Cookies memungkinkan kami:</p>
                    <ul style="text-align: justify">
                        <li>Mengingat Anda sewaktu Anda kembali menggunakan situs kami;</li>
                        <li>Mempercepat atau meningkatkan pencarian yang Anda lakukan;</li>
                        <li>Memperkirakan ukuran dan pola penggunaan Anda pada situs kami;</li>
                        <li>Menyimpan aktivitas web site Anda yang dapat digunakan oleh vendor pihak ketiga; dan
                        </li>
                        <li>memungkinkan kami menyesuaikan situs kami sesuai dengan kepentingan individu Anda.</li>
                    </ul>
                    <p align="justify">Anda dapat menentukan pilihan untuk melakukan modifikasi melalui pengaturan atau
                        setting browser Anda yaitu dengan memilih untuk menolak cookies, namum pilihan ini dapat
                        membatasi layanan optimal pada saat melakukan akses ke situs {{env('APP_NAME')}}.</p>
                    <h3>Data Log (Log Files)</h3>
                    <p align="justify">Data log hanya digunakan dalam bentuk agregat (keseluruhan) untuk menganalisa
                        penggunaan situs kami.</p>
                    <h3>Upgrade data dan informasi pribadi Anda</h3>
                    <p align="justify">Anda dapat memperbarui data dan informasi pribadi Anda melalui pengaturan profil
                        pada akun Anda. Untuk beberapa data dan informasi yang berkaitan dengan akun Anda, kami mungkin
                        akan membutuhkan klarifikasi dari Anda demi kenyamanan dan keamanan akun Anda.</p>
                    <h3>Kritik dan saran</h3>
                    <p align="justify">Jika Anda mempunyai kritik ataupun saran apapun tentang keakuratan informasi atau
                        keluhan privasi silahkan hubungi kami di: </p>
                    <p align="justify">&nbsp;</p>
                    <table width="80%" border="0" cellpadding="3" cellspacing="0" style="text-align: justify">
                        <tr>
                            <td width="16%" valign="top"><strong>Website:</strong></td>
                            <td width="84%" valign="top">{{env('APP_URL')}}</td>
                        </tr>
                        <tr>
                            <td valign="top"><strong>Email:</strong></td>
                            <td valign="top">
                                <p>
                                    <span class="email"><a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a></span>
                                </p>
                            </td>
                        </tr>
                    </table>
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
