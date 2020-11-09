@extends('layouts.mst')
@section('title', 'Ketentuan Layanan | '.env('APP_TITLE'))
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
                    <h3>Pendahuluan</h3>
                    <p align="justify">Terima kasih telah menggunakan produk dan layanan {{env('APP_NAME')}} yang beralamat di Pohkecik, Dlanggu, Mojokerto, Jawa Timur — 61371.</p>
                    <p align="justify"> Bacalah dengan saksama. Dengan menggunakan layanan kami, berarti Anda telah menyetujui persyaratan ini. User Agreement (&ldquo;Perjanjian Pengguna&quot; atau disebut juga &quot;Perjanjian&quot;) ini merupakan dokumen penting yang harus Anda pertimbangkan dengan hati-hati, perjanjian ini berisikan syarat-syarat yang menjelaskan bagi Anda dalam menggunakan situs {{env('APP_NAME')}}.</p>
                    <p align="justify"> Terkadang terjadi persyaratan tambahan dikarenakan kompleksitas dari layanan kami. Persyaratan tambahan tersedia pada layanan yang relevan, dan persyaratan tambahan tersebut menjadi bagian yang tidak terpisahkan dari perjanjian Anda dengan kami jika Anda menggunakan layanan ini.</p>
                    <p align="justify"> Menggunakan layanan kami tidak memberikan Anda kepemilikan atas hak kekayaan intelektual apa pun. Anda tidak boleh menggunakan konten dari layanan kami kecuali jika mendapatkan izin dari pemiliknya atau diizinkan oleh hukum. Persyaratan ini tidak memberikan Anda hak untuk menggunakan merek atau logo apa pun yang digunakan dalam layanan kami. Jangan menghapus, mengaburkan, atau mengubah pemberitahuan masalah hukum apa pun yang ditampilkan atau disertakan pada layanan kami.</p>
                    <p align="justify"> Layanan kami terkadang menampilkan beberapa konten yang bukan milik {{env('APP_NAME')}}. Konten tersebut sepenuhnya menjadi tanggung jawab entitas yang menyediakannya. Kami dapat meninjau konten untuk menentukan apakah konten tersebut ilegal atau melanggar kebijakan kami, dan kami dapat menghapus atau menolak untuk menampilkan konten yang kami yakini melanggar hukum atau kebijakan kami. </p>
                    <p align="justify"> Terkait dengan penggunaan layanan kami oleh Anda, kami dapat mengirimkan pemberitahuan layanan, pesan administratif, dan informasi lain kepada Anda. <br />
                        Perjanjian ini berlaku efektif sejak 10 November 2014.</p>
                    <p align="justify">BACALAH PERJANJIAN INI DENGAN SEKSAMA UNTUK MEMASTIKAN BAHWA ANDA MEMAHAMI SETIAP KETENTUAN. DENGAN MENGGUNAKAN SITUS INI BERARTI ANDA TELAH MEMBACA, MENGERTI, MENERIMA DAN SETUJU UNTUK TERIKAT DENGAN PERJANJIAN INI, UNTUK DIRI SENDIRI DAN/ATAU ATAS NAMA SETIAP ANGGOTA UNTUK SIAPA ANDA MENGGUNAKAN SITUS INI.</p>
                    <p align="justify">&nbsp;</p>
                    <h3>Amandemen Perjanjian Pengguna</h3>
                    <p align="justify">{{env('APP_NAME')}} berhak untuk mengubah atau memodifikasi Perjanjian Pengguna secara keseluruhan atau sebagian dari waktu ke waktu, tanpa pemberitahuan (kecuali pemberitahuan sebelumnya tersebut diwajibkan oleh hukum), kami akan mengirimkan pemberitahuan modifikasi material ke alamat email Anda jika diperlukan. revisi ini juga akan diposting di situs {{env('APP_NAME')}}. Versi terbaru dari Perjanjian Pengguna akan efektif diberlakukan pada saat kami posting.</p>
                    <h3>1. Gambaran Umum</h3>
                    <h4>1.1 Penggunaan Istilah</h4>
                    <p align="justify">Sebagaimana digunakan dalam perjanjian ini dan ketentuan layanan lainnya, istilah berikut memiliki makna seperti di bawah ini, kecuali jika dinyatakan menurut ketentuan atau diharuskan dalam konteks.</p>
                    <ul>
                        <li>
                            <div align="justify"><strong>Afiliasi - </strong>Sebutan bagi anak perusahaan yang sepenuhnya dimiliki oleh PT Panonpoe Media.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Akun</strong> atau <strong>Account - </strong>Kepemilikan sebagai anggota yang dapat mengakses dan menggunakan situs layanan {{env('APP_NAME')}}.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Anda,</strong> <strong>User</strong> atau <strong>Pengguna - </strong>Sebutan bagi pihak yang mengakses layanan atau situs kami untuk alasan apapun, pihak yang dimaksud bisa sebagai (1) individu yang yang menggunakan situs atas nama diri sendiri, atau (2) orang yang menggunakan situs atas nama anggota yang merupakan organisasi, perusahaan atau badan hukum. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Anggota - </strong>Individu atau badan hukum yang mendaftar ke situs {{env('APP_NAME')}}.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Available Balance - </strong>Jumlah dana user yang terdapat di situs {{env('APP_NAME')}}. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Biaya - </strong>Sejumlah dana yang dikenakan {{env('APP_NAME')}} kepada pengguna pada proses aktivitas transfer dari rekening {{env('APP_NAME')}} ke rekening pengguna dan pada pengiriman &ldquo;bukti tanda terima&rdquo; ketika ada permintaan dari pengguna.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Buyer - </strong>Pembeli produk digital.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Fee</strong> - Sejumlah dana dari hasil transaksi yang di kenakan {{env('APP_NAME')}} kepada pengguna.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Freelance - </strong>Melakukan pekerjaan/bisnis tapi tidak terikat pada perusahaan/pemberi kerja/Klien tertentu.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Freelancer - </strong>Pekerja lepas/orang yang melakukan pekerjaan/aktivitas freelance.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Formulir Gugatan - </strong>Surat elektronik yang disediakan situs {{env('APP_NAME')}} yang digunakan penggugat ketika arbitrase. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Kami</strong>, <strong>Penyedia</strong> atau <strong>{{env('APP_NAME')}} - </strong>Sebutan untuk menggantikan kata/sebutan {{env('APP_NAME')}}, afiliasinya dan staff. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Outsource - </strong>Mengalihkan pekerjaan (<em>task</em>) yang perlu diselesaikan kepada pihak lain.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Klien - </strong>Pemilik project atau pengguna jasa Pekerja. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Penggugat - </strong>Pihak yang terlebih dahulu mengajukan arbitrase terhadap project yang berlangsung. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Product - </strong>Benda/barang berupa file, yang dihasilkan atau diperjualbelikan di situs {{env('APP_NAME')}}.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Program Affiliate - </strong>Program yang memungkinkan setiap user di {{env('APP_NAME')}} mendapatkan penghasilan &ldquo;passive income&rdquo; </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Project - </strong>Pekerjaan/tugas yang di-outsource oleh Klien kepada Pekerja di situs {{env('APP_NAME')}}.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Register - </strong>Sebutan saat Anda mendaftar untuk menjadi anggota dan menggunakan situs layanan {{env('APP_NAME')}}. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Seller -</strong> Pemilik/penjual produk digital. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Sengketa</strong> atau <strong>Perselisihan -</strong> Ketidakpuasan atau ketidaksefahaman antara Klien dan Pekerja pada project yang berlangsung, dimana salah satu pihak melakukan gugatan terhadap project tersebut.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Service</strong> - Sebuah model transaksi sebagai kombinasi/simbiosis dari transaksi jual beli produk diigital dan transaksi project.</div>
                        </li>
                        <li>
                            <div align="justify"><strong>Situs</strong> - Tempat layanan, hosting, pemeliharaan, dan semua fasilitas yang disediakan di situs {{env('APP_NAME')}}. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Staff</strong> - Sebutan untuk seluruh personil dari Dirut sampai karyawan di PT Panonpoe Media. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Tergugat</strong> - Pihak yang diarbitrase. </div>
                        </li>
                        <li>
                            <div align="justify"><strong>Pekerja -</strong>Penyedia jasa atau pekerja bebas (<em>freelance</em>) dengan <em>skillset</em> khusus yang mengerjakan project dari Klien.</div>
                            <ul>
                            </ul>
                        </li>
                    </ul>
                    <h4>1.2 Mekanisme Dasar</h4>
                    <p align="justify">{{env('APP_NAME')}} merupakan &ldquo;<em>Project and Digital produk Marketplace</em>&rdquo; atau tempat transaksi (menawarkan project dan mencari project) secara online antara <strong>Klien</strong> <em>(pemberi kerja/ pengguna jasa) </em>dan <strong>Pekerja</strong> <em>(pekerja/ penyedia jasa). </em> juga transaksi jual beli produk digital antara <strong>seller</strong> (penjual produk) dan <strong>buyer</strong> (pembeli produk), Ada juga service sebagai perpaduan antara transaksi jual beli dengan transaksi project</p>
                    <p align="justify">Dengan demikian ada 3 (tiga) macam transaksi yang dapat dilakukan di {{env('APP_NAME')}}: </p>
                    <h5>1) Transaksi Project, Antara Klien dan Pekerja</h5>
                    <p align="justify">&ldquo;<em>Semua pekerjaan yang hasil akhirnya bisa dikemas dalam bentuk file</em>&rdquo; bisa dikerjakan di {{env('APP_NAME')}}.</p>
                    <h5>2) Transaksi Jual Beli Produk Digital, Antara Seller dan Buyer</h5>
                    <p align="justify">&ldquo;<em>Semua produk digital yang bisa dikemas dalam bentuk file</em>&rdquo; bisa diperjualbelikan di space penjualan {{env('APP_NAME')}}.</p>
                    <h5>3) Service</h5>
                    <p>Merupakan model transaksi kombinasi/simbosis antara transaksi jual beli produk digital dengan transaksi project.</p>
                    <h3>2. Pengguna</strong> </h3>
                    <p align="justify">Individu atau kelompok (organisasi atau perusahaan) menjadi anggota ketika mereka membuka akun di {{env('APP_NAME')}} sesuai dengan ketentuan yang berlaku. Sebagai anggota, mereka berhak menggunakan direktori situs dan fasilitas yang telah disediakan oleh {{env('APP_NAME')}} untuk mengiklankan pekerjaan, mencari pekerjaan, mempromosikan produk atau membeli produk.</p>
                    <p align="justify">Pengguna hanya menggunakan situs untuk berkolaborasi di dalam transaksi project atau transaksi jual beli dengan prinsip untuk saling menguntungkan. Setiap pengguna bertanggung jawab atas apa yang terjadi pada akun mereka dan harus melaporkan setiap penggunaan yang tidak sah dari akun mereka kepada kami. </p>
                    <h4>2.1 Syarat Pengguna</h4>
                    <p align="justify">Layanan atau situs {{env('APP_NAME')}} memiliki kebijaksanaan mutlak untuk menerima atau menolak pengguna tertentu (individu, organisasi atau perusahaan):</p>
                    <ul>
                        <li> Individu berusia diatas 17 (tujuh belas) tahun;</li>
                        <li>Organisasi atau Perusahaan (melampirkan akta pendirian perusahaan atau keterangan lainnya sesuai dengan hukum yang berlaku).</li>
                    </ul>
                    <p align="justify">Jika pengguna tidak memenuhi persyaratan sebagaimana yang telah ditetapkan, Anda tidak dapat menggunakan layanan {{env('APP_NAME')}}. Setiap Pengguna bertanggung jawab terhadap apa yang terjadi pada akun Anda dan harus melaporkan setiap penggunaan yang tidak sah dari akun Anda kepada kami.</p>
                    <h4>2.2 Keanggotaan</h4>
                    <p align="justify">{{env('APP_NAME')}} berhak untuk me-non-aktifkan keanggotaan siapa saja tanpa pemberitahuan, jika memiliki kondisi seperti berikut:</p>
                    <ul>
                        <li>
                            <div align="justify">Individu dibawah 17 (tujuh belas) tahun;</div>
                        </li>
                        <li>
                            <div align="justify">Organisasi atau Perusahaan yang mendaftarkan brand/nama perusahaan yang tidak memiliki bukti valid;</div>
                        </li>
                        <li>
                            <div align="justify">Memiliki akun ganda;</div>
                        </li>
                        <li>
                            <div align="justify">Membuat kesepakatan di luar {{env('APP_NAME')}} berkaitan dengan project dengan menawarkan transaksi secara langsung, seperti mentransfer langsung ke rekening Pekerja tanpa melalui rekening {{env('APP_NAME')}}. </div>
                        </li>
                    </ul>
                    <h4>2.3 Ketentuan Pengguna</h4>
                    <p align="justify">Pengguna mengerti dan setuju dengan kenyataan bahwa {{env('APP_NAME')}} hanya bertindak sebagai fasilitator dan mediator atau tempat online yang memungkinkan pengguna untuk melakukan transaksi project ataupun transaksi jual beli secara online. Akibatnya pengguna mengakui dan setuju {{env('APP_NAME')}} tidak memiliki kontrol atas kualitas atau legalitas dari layanan profesional yang diberikan oleh pengguna pada situs kami, kemampuan pengguna untuk menyediakan jasa atau menyelesaikan pekerjaan atau ketersediaan produk-produk digital yang diperjualbelikan. Kami tidak menjamin bahwa Pengguna benar-benar akan melengkapi layanan profesional atau bertindak secara benar dalam menggunakan situs kami.</p>
                    <p align="justify"> Kami berharap Pengguna dapat secara optimal melakukan praktek dan aktifitas yang diperlukan serta menggunakan hati dan akal sehat saat menggunakan situs {{env('APP_NAME')}}. </p>
                    <h4>2.4 Aturan Main</h4>
                    <p align="justify">Pengguna harus mematuhi kebijakan apa pun yang tersedia di dalam layanan kami, oleh karena itu pengguna dilarang:</p>
                    <ul>
                        <li>
                            <div align="justify">Memposting, mengerjakan, menjual atau membeli pekerjaan atau produk yang melawan hukum, seperti: Judi, Pornografi, Narkoba, Korupsi, Traficking, dll; </div>
                        </li>
                        <li>
                            <div align="justify"> Memposting, mengerjakan, menjual atau membeli pekerjaan atau produk yang mendiskreditkan atau menyerang Suku, Agama, Ras, Antar Golongan (SARA); </div>
                        </li>
                        <li>
                            <div align="justify"> Mengiklankan situs web di situs {{env('APP_NAME')}}. Setiap URL yang diposting harus berhubungan dengan project di {{env('APP_NAME')}}; </div>
                        </li>
                        <li>
                            <div align="justify"> Meniru website atau sistem {{env('APP_NAME')}}; menyalin, menampilkan, memodifikasi, mendistribusikan, memproduksi, memberi ijin, mentransfer, atau menjual kembali setiap isi, produk dan informasi (termasuk dan tidak terbatas pada; pesan, data, teks, audio, video, foto, grafik, ikon, software atau informasi lainnya), atau jasa yang diperoleh dari atau melalui situs ini; </div>
                        </li>
                        <li>
                            <div align="justify"> Menyalahgunakan hak cipta, hak paten, merek dagang, rahasia dagang, atau hak kekayaan intelektual lainnya atau hak milik atau hak publisitas atau privasi pihak lain;</div>
                        </li>
                        <li>
                            <div align="justify">Membuat kesepakatan di luar {{env('APP_NAME')}} berkaitan dengan project dengan menawarkan transaksi secara langsung, seperti mentransfer langsung ke rekening Pekerja tanpa melalui rekening {{env('APP_NAME')}}; </div>
                        </li>
                        <li>
                            <div align="justify"> Menegosiasikan fee atau memberikan layanan gratis kepada pengguna lain, sebelum, selama ataupun sesudah project dikerjakan; </div>
                        </li>
                        <li>
                            <div align="justify"> Membuat akun ganda; </div>
                        </li>
                        <li>
                            <div align="justify">Membatalkan project :
                                <ul>
                                    <li> Klien:
                                        <ul>
                                            <li>Membatalkan project pada saat project di publish, dikenakan penalti berupa pengurangan poin reputasi sebesar -2 (minus dua) poin dikali nilai project dibagi seratus ribu (-2 * nilai project /100.000);</li>
                                            <li>Membatalkan project setelah memilih pemenang dikarenakan gagal bayar dikenakan penalti berupa pengurangan poin reputasi sebesar -5 (minus lima) poin dikali nilai project dibagi seratus ribu (-5 * nilai project /100.000);</li>
                                            <li>Membatalkan project ketika Pekerja sudah memulai pekerjaan atau pada saat pekerjaan berjalan, hanya dapat dilakukan melalui jalur arbitrase.</li>
                                        </ul>
                                    </li>
                                    <li>Pekerja:
                                        <ul>
                                            <li>Membatalkan project ketika Klien sudah menyelesaikan pembayaran biaya project atau pada saat pekerjaan berjalan, hanya dapat dilakukan melalui jalur arbitrase.</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div align="justify">Membocorkan informasi atau dokumen yang diperoleh, kecuali dipersyaratkan oleh hukum atau kewenangan yang diberikan; </div>
                        </li>
                        <li>
                            <div align="justify"> Memberikan tanggapan palsu; </div>
                        </li>
                        <li>
                            <div align="justify"> Memberikan kritikan negatif atau yang tidak sehat, </div>
                        </li>
                        <li>
                            <div align="justify"> Memberikan komentar yang berlebihan atau yang merendahkan pihak lain; </div>
                        </li>
                        <li>
                            <div align="justify"> Terlibat konflik personal atau perlakuan yang tidak profesional; </div>
                        </li>
                        <li>
                            <div align="justify"> Terlibat dalam tindakan penipuan yang dilakukan oleh pengguna lain atau oleh pihak ketiga.</div>
                        </li>
                    </ul>
                    <p align="justify">Jangan menyalahgunakan layanan kami. Kami dapat menangguhkan atau menghentikan penyediaan layanan kami bagi Anda jika Anda tidak mematuhi persyaratan atau kebijakan kami, atau jika kami mendapati perilaku yang tidak semestinya. Harap dicatat bahwa kami mungkin akan menangguhkan, membatasi, atau menutup akses Anda ke akun {{env('APP_NAME')}} Anda atau layanan yang diberikan oleh situs kami, dan/atau akses ke rekening Anda jika Anda melakukan kegiatan yang bertentangan dengan Perjanjian Pengguna ini dan kebijakan yang terkait. </p>
                    <h4>2.5 Penalty dan Reward</h4>
                    <p>Penalty dan reward diberikan kepada user untuk beberapa kasus atau tindakan sebagai berikut:</p>
                    <h5>1) Penalty</h5>
                    <ul>
                        <li>Klien
                            <ul>
                                <li>
                                    <div align="justify">Cancel publish project, dikenakan penalti berupa pengurangan poin reputasi sebesar -2 (minus dua) poin dikali nilai project dibagi seratus ribu (-2*nilai project/100.000);</div>
                                </li>
                                <li>
                                    <div align="justify">Melakukan pembayaran order project setelah 7x24 jam sejak email &quot;Instruksi Pembayaran&quot; disampaikan, dikenakan penalti berupa pengurangan poin reputasi sebesar -5 (minus lima) poin dikali nilai project dibagi seratus ribu (-5*nilai project/100.000).<br />
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>Pekerja
                            <ul>
                                <li>
                                    <div align="justify">Terlambat memberikan weekly report, dikenakan penalti berupa pengurangan poin reputasi sebesar -1 (minus satu) poin dikali nilai project dibagi seratus ribu (-1*nilai project/100.000).<br />
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>Buyer
                            <ul>
                                <li>
                                    <div align="justify">Melakukan pembayaran order pembelian produk digital setelah 7x24 jam sejak email &quot;Instruksi Pembayaran&quot; disampaikan, dikenakan penalti berupa pengurangan poin reputasi sebesar -5 (minus lima) poin dikali price dibagi seratus ribu (-5*price/100.000).<br />
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>Tergugat pada arbitrase
                            <ul>
                                <li>
                                    <div align="justify">Mendapat panggilan pertama, dikenakan penalti berupa pengurangan poin reputasi sebesar -2 (minus dua) poin dikali nilai project dibagi seratus ribu (-2*harga project/100.000);</div>
                                </li>
                                <li>
                                    <div align="justify">Mendapat panggilan ke dua, dikenakan penalti berupa pengurangan poin reputasi sebesar -2 (minus dua) poin dikali nilai project dibagi seratus ribu (-2*harga project/100.000);</div>
                                </li>
                                <li>
                                    <div align="justify">Mendapat panggilan ke tiga, dikenakan penalti berupa pengurangan poin reputasi sebesar -2 (minus dua) poin dikali nilai project dibagi seratus ribu (-2*harga project/100.000).</div>
                                </li>
                            </ul></li>
                    </ul>
                    <h5>2) Reward</h5>
                    <ul>
                        <li>Klien
                            <ul>
                                <li>
                                    <div align="justify">Melakukan pembayaran order project sebelum 3x24 jam sejak email &quot;Instruksi Pembayaran&quot; disampaikan, mendapatkan reward berupa penambahan poin reputasi sebesar 1 (satu) poin dikali nilai project dibagi seratus ribu (1*nilai project/100.000);</div>
                                </li>
                                <li>
                                    <div align="justify">Memberikan testimony dan rating kepada Pekerja terhadap hasil pekerjaan mendapatkan reward berupa penambahan poin reputasi sebesar 1 (satu) poin dikali nilai project dibagi seratus ribu (1*nilai project/100.000).<br />
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>Pekerja
                            <ul>
                                <li>
                                    <div align="justify">Cancel project yang dimenangkan dikarenakan Klien gagal bayar, mendapatkan reward berupa penambahan poin reputasi sebesar minimal 1 (satu) poin dan maksimal 20 (dua puluh) poin dari (accept budget/1.000.000);</div>
                                </li>
                                <li>
                                    <div align="justify">Memberikan testimony dan rating kepada Klien terhadap hasil pekerjaan mendapatkan reward berupa penambahan poin reputasi sebesar 1 (satu) poin dikali nilai project dibagi seratus ribu (1*nilai project/100.000). <br />
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>Buyer
                            <ul>
                                <li>
                                    <div align="justify">Melakukan pembayaran order pembelian produk digital sebelum 3x24 jam sejak email &quot;Instruksi Pembayaran&quot; disampaikan, mendapatkan reward berupa penambahan poin reputasi sebesar 1 (satu) poin dikali nilai project dibagi seratus ribu (1*price/100.000).</div>
                                    <br />
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <h3> 3. Hubungan Pengguna dan {{env('APP_NAME')}}</h3>
                    <p align="justify">Situs ini adalah sebuah situs web yang dinamis. Dengan demikian, informasi pada situs akan sering berubah, ada kemungkinan bahwa beberapa informasi dapat dianggap menyimpang, berbahaya, atau tidak akurat, dan dalam beberapa kasus mungkin disalahartikan atau dipalsukan oleh pengguna atau oleh pihak ketiga yang secara sengaja atau tidak sengaja, terlepas apakah pengguna atau pihak ketiga tersebut dengan atau tanpa tujuan bisnis yang sah.</p>
                    <p align="justify"> {{env('APP_NAME')}} menyediakan akses dimonitor untuk konten pihak pengguna. {{env('APP_NAME')}} hanya bertindak sebagai tempat atau media dan tidak memiliki kewajiban atau terkait dengan konten pihak ketiga pada situs ini, baik yang timbul di bawah hukum hak cipta atau kekayaan intelektual pihak lain, fitnah, pencemaran nama baik, privasi, norma kesusilaan, atau disiplin hukum lainnya. Situs web {{env('APP_NAME')}} mungkin berisi link ke situs web pihak ketiga, kami tidak mungkin mampu melakukan kontrol atau selalu meninjau situs web yang di link dari situs web {{env('APP_NAME')}}, karena itu kami tidak selalu dapat mendukung konten, produk, jasa, kebijakan, atau kinerja situs web kami ketika di link ke situs pihak ketiga ataupun sebaliknya situs pihak ketiga di link ke situs {{env('APP_NAME')}} dan Pengguna seharusnya tidak memperlakukan semua link seperti apa adanya.</p>
                    <p align="justify">{{env('APP_NAME')}} bukanlah pihak yang terlibat secara langsung dalam transaksi antara pengguna, baik dalam hal transaksi project ataupun dalam transaksi jual beli, {{env('APP_NAME')}} tidak melakukan intervensi apapun terhadap pengguna dalam hubungannya antara Klien dengan Pekerja ataupun dalam hubungannya antara seller dengan buyer. {{env('APP_NAME')}} hanya membuat situs layanan yang tersedia untuk memungkinkan pengguna mengidentifikasi dan menentukan kesesuaian terhadap transaksi yang akan mereka lakukan. {{env('APP_NAME')}} tidak memiliki kontrol atas, jaminan kualitas, keamanan atau legalitas jasa pengguna yang dipromosikan melalui situs kami, kebenaran atau keakuratan dari daftar pekerjaan, kualifikasi, latar belakang, atau identitas pengguna, kemampuan pengguna untuk memberikan layanan terhadap pengguna lainnya, atau bahwa pengguna dapat menyelesaikan atau benar-benar akan menyelesaikan transaksi. Kapasitas {{env('APP_NAME')}} hanya sebagai fasilitator, Mediator dan Penjamin, yang memfasilitasi semua proses transaksi agar berjalan secara fair play, jujur, adil dan transfaran. Yang memediasi terhadap hak dan kewajiban masing-masing pihak agar tidak ada pihak yang dirugikan, dan yang Menggaransi bahwa semua transaksi akan berjalan sesuai dengan ketentuan yang berlaku. Untuk itu segala bentuk komunikasi  harus dilakukan di situs {{env('APP_NAME')}}, baik menggunakan thread maupun menggunakan fasilitas real-time chat yang telah disediakan. Ketika terjadi sengketa dan salah satu pihak mengajukan arbitrase, hanya pembicaraan dalam situs {{env('APP_NAME')}} yang dapat diajukan sebagai bukti dan bahan pertimbangan dalam pengambilan keputusan, tim arbitrator {{env('APP_NAME')}} akan memediasi seadil-adilnya kepada kedua belah pihak berdasarkan dokumen komunikasi tersebut dan rekaman pekerjaan selama project berlangsung.</p>
                    <p align="justify">Jika pengguna melakukan pembicaraan diluar situs {{env('APP_NAME')}} (misal, pengguna berkomunikasi menggunakan SMS, Whatsapp, BBM, telepon, email pribadi), {{env('APP_NAME')}} tidak memiliki catatan (log) pembicaraan pengguna.</p>
                    <p align="justify"> {{env('APP_NAME')}} hanya memberikan informasi sebatas apa yang disampaikan pengguna pada instrumen yang telah disediakan pada situs kami, adapun kualitas terhadap informasi tersebut sangat bergantung dari kesungguhan dan niat baik pengguna. Sistem yang dibangun dan didisain {{env('APP_NAME')}} telah berusaha untuk meminimalisir dari pengguna yang tidak memiliki kesungguhan dan niat baik ataupun dari pihak ketiga yang secara sengaja atau tidak mencoba mengaburkan atau memalsukan informasi yang tersedia.</p>
                    <p align="justify"> {{env('APP_NAME')}} memberikan informasi tersebut semata-mata untuk kenyamanan pengguna dan bukan sebagai dukungan atau rekomendasi dari {{env('APP_NAME')}}.</p>
                    <p align="justify"> {{env('APP_NAME')}} memberikan informasi tersebut semata-mata untuk kenyamanan pengguna dan bukan sebagai dukungan atau rekomendasi dari {{env('APP_NAME')}}. </p>
                    <h4>3.1 Mengunggah (Upload) Materi ke Situs Kami</h4>
                    <p align="justify">Setiap materi yang Anda unggah untuk keperluan melengkapi profil Anda di situs {{env('APP_NAME')}} akan dianggap materi yang tidak bersifat rahasia dan tidak dilindungi oleh hak kepemilikan dan kami berhak menggunakan, menyalin, menyebar-luaskan dan mengungkapkan materi tersebut kepada pihak ketiga untuk tujuan yang berkaitang dengan promosi atau transaksi, namun demikian Anda tetap memiliki privasi untuk mempublish atau tidak beberapa informasi pribadi pada profil Anda di situs kami dengan menyeting profil Anda pada akun Anda di situs kami.</p>
                    <p align="justify"> Kami tidak bertanggung jawab atau berkewajiban kepada pihak ketiga atas isi atau ketepatan dari materi yang ditempatkan oleh pengguna pada situs kami. Kami berhak menghapus materi atau posting yang Anda buat di situs kami apabila hal itu bersifat offensive, dapat memicu kebencian, mencemarkan nama baik atau bertentangan berdasarkan hukum dan ketentuan yang berlaku di Indonesia. Kami juga berhak mengungkapkan identitas Anda kepada pihak ketiga yang mengklaim bahwa materi yang ditempatkan atau diunggah oleh Anda ke situs kami merupakan pelanggaran terhadap hak kekayaan intelektual mereka atau hak pribadi mereka. </p>
                    <h4>3.2 Penerima Manfaat</h4>
                    <p align="justify">Pengguna mengakui dan menyetujui bahwa reputasi dan informasi dari situs bergantung pada kesungguhan dan niat baik serta kinerja pengguna. Pengguna menunjuk {{env('APP_NAME')}} sebagai pihak penerima manfaat dari kontrak anggota pengguna untuk tujuan menegakkan hak dan kewajiban pengguna. Pengguna selanjutnya setuju {{env('APP_NAME')}} yang memiliki hak untuk mengambil tindakan tanpa batasan apapun terhadap kontrak anggota atau akun pengguna jika dianggap perlu.</p>
                    <h4>3.3 Kedudukan Hubungan</h4>
                    <p align="justify">Perjanjian ini dan penggunaan situs ini tidak akan ditafsirkan sebagai menciptakan atau menyiratkan hubungan badan, waralaba, kemitraan atau usaha patungan antara pengguna dan {{env('APP_NAME')}}, kecuali dan hanya sebatas hubungan antara penyedia dan pengguna.</p>
                    <h4>3.4 Hubungan Antara Pengguna</h4>
                    <p align="justify">Setiap pengguna mengakui dan setuju bahwa rekomendasi yang dibuat oleh {{env('APP_NAME')}} sehubungan dengan transaksi yang diselenggarakan hanya sebatas support, bahwa pengguna bertanggung jawab dalam mengidentifikasi dan kemudian membuat keputusan mereka sendiri.</p>
                    <h5 align="justify">1) Transaksi Project</h5>
                    <p align="justify">Penentuan kesesuaian atau tidaknya Pekerja untuk melakukan atau menyelesaikan setiap project yang dimaksud atau penentuan kesesuaian atau tidaknya Klien tentang deskripsi project, besaran dana dan jangka waktu pengerjaan project yang dimaksud, bahwa Klien dan Pekerja mengakui itu adalah tanggung jawab mereka untuk menilai kemampuan masing-masing pihak.</p>
                    <p align="justify">Terhadap project yang berhasil dikerjakan Pekerja, maka dengan ini Pekerja menyatakan:</p>
                    <ul>
                        <li>Bersedia memberikan <strong> fee sebesar 12%</strong> (duabelas persen) kepada {{env('APP_NAME')}}.</li>
                        <li>Akan menyelesaikan project sesuai dengan deskripsi yang diberikan oleh Project Klien.</li>
                        <li>Siap bekerja sama dan menjaga komunikasi dengan Project Klien dan Admin {{env('APP_NAME')}} untuk bersama menyukseskan project ini sampai selesai.</li>
                        <li>Bersedia menyerahkan seluruh hasil kerja Pekerja termasuk source code yang Pekerja tulis.</li>
                        <li>Khusus untuk pekerjaan <strong><em>&quot;Layout, Logo &amp; Graphic Design&quot;</em></strong> menjadi hak eksklusif bagi Klien, dimana Pekerja tidak mempunyai hak untuk menggunakan, memodifikasi, memperbanyak dan/atau memperjualbelikan hasil pekerjaan Pekerja, kecuali dengan seizin atau persetujuan Klien.</li>
                        <li>Tidak membuat kesepakatan dengan Project Klien di luar {{env('APP_NAME')}} berkaitan dengan project ini, seperti mentransfer langsung ke rekening saya tanpa melalui rekening {{env('APP_NAME')}}.</li>
                        <li>Terhadap pelanggaran ini saya bersedia dikenakan sanksi tegas oleh {{env('APP_NAME')}}. </li>
                    </ul>
                    <p align="justify"> Klien dan Pekerja secara yuridiksi memiliki hak di bawah jaminan hukum yang sah yang tidak dapat dikecualikan. Tidak ada dalam perjanjian ini dimaksudkan untuk mengesampingkan hak yang dibenarkan oleh hukum yang berlaku. Namun pada batas maksimal yang diizinkan oleh hukum, tanggung jawab {{env('APP_NAME')}} untuk setiap layanan yang disediakan sebatas pada aspek pelayanan atau penyediaan fasilitas yang memungkinkan Klien dan Pekerja bisa bekerja secara baik dan benar.</p>
                    <h6 align="justify">Ketentuan Pelaksanaan Project: </h6>
                    <p align="justify">{{env('APP_NAME')}} akan mengkonfirmasi kepada Pekerja pemenang project untuk mulai mengerjakan project ketika Klien telah menyelesaikan pembayaran order, sebagai jaminan bahwa Pekerja pasti di bayar ketika pekerjaan telah selesai. Pembayaran dapat dilakukan dengan cara mentransfer ke salah satu rekening {{env('APP_NAME')}} atas nama PT Panonpoe Media atau dengan menggunakan fasilitas kartu kredit.</p>
                    <p align="justify">Setelah Klien memberikan project kepada Pekerja dan Pekerja menerima project tersebut melalui situs {{env('APP_NAME')}}, Klien setuju untuk menyerahkan project, dan Pekerja setuju untuk memberikan jasa (menyelesaikan project) sesuai dengan kesepakatan sebagai berikut:</p>
                    <ul>
                        <li>
                            <div align="justify">Perjanjian Pengguna;</div>
                        </li>
                        <li>
                            <div align="justify"> Ketentuan lainnya yang diterima oleh Pekerja dan Klien diupload ke situs, sejauh tidak bertentangan dengan Perjanjian Pengguna;</div>
                        </li>
                        <li>
                            <div align="justify"> Istilah Project diberikan dan diterima di situs {{env('APP_NAME')}}, sejauh tidak bertentangan dengan Perjanjian Pengguna.</div>
                        </li>
                    </ul>
                    <p align="justify">{{env('APP_NAME')}} setuju untuk menyediakan semua fasilitas di situs {{env('APP_NAME')}}, termasuk hosting project. </p>
                    <p align="justify">Anda setuju untuk <em>tidak mematuhi</em> setiap ketentuan yang bertentangan dengan Perjanjian Pengguna. Setiap ketentuan dan kontrak anggota yang bertentangan dengan Perjanjian Pengguna dinyatakan batal. </p>
                    <h5>2) Transaksi Jual Beli</h5>
                    <p align="justify">Penentuan kesesuaian atau tidaknya produk digital yang dijual seller tentang <em>nama produk, deskripsi produk dan harga produk</em> untuk dapat memenuhi kebutuhan pembeli (buyer) adalah menjadi tanggungjawab pengguna. {{env('APP_NAME')}} hanya berupaya bahwa terhadap semua produk digital yang dijual seller di situs {{env('APP_NAME')}} dapat dioperasikan sebagaimana mestinya. Adapuan kualitas dari produk digital yang dimaksud untuk dapat memenuhi keinginan atau kepuasan buyer adalah sesuatu yang tidak dapat kami control secara penuh.</p>
                    <h6 align="left">Ketentuan Produk digital:</h6>
                    <p align="justify">{{env('APP_NAME')}} akan menyeleksi dan memverifikasi terlebih dulu semua produk digital yang diupload seller ke situs {{env('APP_NAME')}}, untuk memastikan bahwa semua produk digital tersebut adalah produk yang aman dan berkualitas.</p>
                    <p align="justify"><strong>Aman</strong>, bahwa produk seller tidak mengandung unsur yang dilarang, seperti:</p>
                    <ul>
                        <li>
                            <div align="justify">Produk yang melawan hukum, seperti: Judi, Pornografi, Narkoba, Korupsi, Traficking, dll;</div>
                        </li>
                        <li>
                            <div align="justify">Produk yang mendiskreditkan atau menyerang; Suku, Agama, Ras, Antar Golongan (SARA).</div>
                        </li>
                    </ul>
                    <p><strong>Berkualitas</strong>, bahwa produk yang diupload seller dapat berfungsi dengan baik sebagaimana peruntukan dan spesifikasi produk.</p>
                    <p align="justify">Jika hasil pemeriksaan tim tester {{env('APP_NAME')}} menyatakan produk seller layak untuk di publish, maka produk digital tersebut akan dipublish pada space penjualan {{env('APP_NAME')}} selambat-lambatnya dalam 5 (lima) hari kerja, sejak admin {{env('APP_NAME')}} menyampaikan pemberitahuan penerimaan upload produk seller.</p>
                    <p align="justify">Seller harus mempertanggungjawabkan terhadap produk digital yang dijual seller di {{env('APP_NAME')}}, bahwa produk tersebut bukanlah produk yang menyalahgunakan hak cipta, hak paten, merek dagang, rahasia dagang, atau hak kekayaan intelektual lainnya atau hak milik atau hak publisitas atau privasi pihak lain. Pelanggaran terhadap ketentuan ini seller dapat dikenakan sanksi hukum sebagaimana hukum yang berlaku di Republik Indonesia. Terhadap penyalahgunaan tersebut {{env('APP_NAME')}} beserta afiliasinya menyatakan tidak bertanggungjawab.</p>
                    <p align="justify">Produk digital dengan kapasitas lebih dari 250MB tidak dapat diupload secara online, seller dapat mengirim produk digital seller secara langsung atau melalui pos dengan alamat :</p>
                    <p align="justify">Kepada {{env('APP_NAME')}}<br />
                        Komp. Permata Mekar Mulya Blok G No. 1 Panghegar - Bandung 40614</p>
                    <p align="justify">Terhadap produk digital yang di upload seller ke situs {{env('APP_NAME')}}, maka dengan ini seller menyatakan:</p>
                    <ul>
                        <li>
                            <div align="justify">Menerima keputusan hasil verifikasi tim tester Projects,co,id; </div>
                        </li>
                        <li>
                            <div align="justify">Memberikan hak kepada {{env('APP_NAME')}} untuk menjual produk digital seller melalui situs {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">Bersedia memberikan penjelasan kepada buyer tentang produk digital yang dimaksud jika diperlukan;</div>
                        </li>
                        <li>
                            <div align="justify">Bersedia membayar fee sebesar 20% (duapuluh persen) dari total penjualan produk digital tersebut kepada {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">Memiliki hak intelektual penuh atas produk digital tersebut. Produk digital tersebut tidak menyalahgunakan hak cipta, hak paten, merek dagang, rahasia dagang, atau hak kekayaan intelektual lainnya atau hak milik atau hak publisitas atau privasi pihak lain;</div>
                        </li>
                        <li>
                            <div align="justify">Produk digital tersebut bukan produk yang meniru website atau sistem {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">Memberikan sebagian hak intelektual atas produk digital tersebut kepada buyer untuk dipergunakan sebagaimana mestinya;</div>
                        </li>
                        <li>
                            <div align="justify">Melarang buyer untuk memodifikasi dan/atau memperjualbelikan produk digital tersebut;</div>
                        </li>
                    </ul>
                    <p align="justify">Seller dan buyer secara yuridiksi memiliki hak di bawah jaminan hukum yang sah yang tidak dapat dikecualikan. Tidak ada dalam perjanjian ini dimaksudkan untuk mengesampingkan hak yang dibenarkan oleh oleh hukum yang berlaku. Namun pada batas maksimal yang diizinkan oleh hukum, tanggung jawab {{env('APP_NAME')}} untuk setiap layanan yang disediakan sebatas pada aspek pelayanan atau penyediaan fasilitas yang memungkinkan seller dan buyer bisa bertransaksi secara jujur dan terbuka.</p>
                    <p align="justify"> Setelah seller dan buyer sepakat terhadap transaksinya melalui situs {{env('APP_NAME')}}, seller setuju untuk menyerahkan produk, dan buyer menerima produk digital yang dimaksud, sesuai dengan kesepakatan sebagai berikut:</p>
                    <ul>
                        <li>
                            <div align="justify">Perjanjian Pengguna; </div>
                        </li>
                        <li>
                            <div align="justify">Ketentuan lainnya yang diterima oleh seller dan buyer diupload ke situs, sejauh tidak bertentangan dengan Perjanjian Pengguna;</div>
                        </li>
                        <li>
                            <div align="justify">Istilah Transaksi Jual Beli diberikan dan diterima di situs {{env('APP_NAME')}}, sejauh tidak bertentangan dengan Perjanjian Pengguna.</div>
                        </li>
                    </ul>
                    <p align="justify">{{env('APP_NAME')}} setuju untuk menyediakan semua fasilitas di situs {{env('APP_NAME')}}, termasuk hosting produk. </p>
                    <p align="justify">Anda setuju untuk <em>tidak mematuhi</em> setiap ketentuan kontrak yang bertentangan dengan Perjanjian Pengguna. Setiap ketentuan dari kontrak anggota yang bertentangan dengan Perjanjian Pengguna dinyatakan batal. </p>
                    <h5>3) Service</h5>
                    <p align="justify">Merupakan simbiosis atau kombinasi antara transaksi jual beli produk digital dengan transaksi project. Melalui service seller/Pekerja dapat menawarkan keahlian yang dimilikinya untuk suatu pekerjaan tertentu, dan ketika buyer/Klien membeli service tersebut maka proses akan berlanjut kepada pembuatan project, sehingga hal-hal yang berkaitan dengan aturan atau ketentuan pada transaksi project (pembuatan project) berlaku pula pada service.</p>
                    <h3> 4. Akun</h3>
                    <h4>4.1 Pembukaan Akun</h4>
                    <p align="justify">Untuk menjadi pengguna dan dapat mengakses situs {{env('APP_NAME')}} dan menggunakan direktori situs dan fasilitas yang telah disediakan oleh {{env('APP_NAME')}} untuk mengiklankan pekerjaan, mencari pekerjaan, mempromosikan produk atau membeli produk. Anda harus mendaftar terlebih dahulu, proses pendaftaran sangat mudah dan tidak dipungut biaya apapun. Selanjutnya Anda setuju untuk melengkapi informasi Anda dengan informasi yang benar, akurat dan lengkap pada profil Anda pada situs kami, Anda juga bisa memperbarui informasi tentang profil Anda, untuk mempertahankan dan meningkatkan peluang bisnis Anda.</p>
                    <p align="justify"> Anda setuju bahwa beberapa informasi serta instrument yang terdapat dalam akun Anda adalah sesuatu yang bersifat pribadi dan rahasia dan Anda setuju untuk bertanggung jawab atas apa yang terjadi pada akun Anda dan harus melaporkan setiap penggunaan yang tidak sah dari akun Anda kepada kami. </p>
                    <h4>4.2 Verifikasi</h4>
                    <p align="justify">Agar akun Anda aktif, {{env('APP_NAME')}} akan meminta Anda untuk memverifikasi email Anda terlebih dulu, didalamnya juga terdapat informasi tentang username dan password Anda, demi keamanan akun Anda segera ubah password Anda.</p>
                    <h4>4.3 Perubahan Akun</h4>
                    <p align="justify">Anda dapat melakukan perubahan ataupun penambahan informasi pada akun Anda, namun pada beberapa perubahan Anda mungkin akan diminta memberikan klarifikasi seperti email, password dan nomor handphone Anda, ada juga perubahan yang hanya bisa dilakukan dengan cara menghubungi admin {{env('APP_NAME')}}, seperti ketika Anda ingin mengubah username Anda.</p>
                    <h4>4.4 Penonaktifan Akun</h4>
                    <p align="justify">Pengguna yang sudah terdaftar di {{env('APP_NAME')}} tidak perlu menon-aktifkan keanggotaannya di {{env('APP_NAME')}} karena {{env('APP_NAME')}} tidak mengenakan sanksi apapun kepada pengguna ketika akun pengguna tidak aktif.<br />
                        Tetapi {{env('APP_NAME')}} berhak untuk menon-aktifkan keanggotaan pengguna dengan atau tanpa peringatan terlebih dahulu, jika memiliki kondisi seperti berikut:</p>
                    <ul>
                        <li>
                            <div align="justify">Individu dibawah 17 (tujuh belas) tahun;</div>
                        </li>
                        <li>
                            <div align="justify">Organisasi atau Perusahaan yang mendaftarkan brand/nama perusahaan yang tidak memiliki bukti valid;</div>
                        </li>
                        <li>
                            <div align="justify">Memiliki akun ganda.</div>
                        </li>
                        <li>
                            <div align="justify">Memposting, mengerjakan, menjual atau membeli pekerjaan atau produk yang melawan hukum, seperti: Judi, Pornografi, Narkoba, Korupsi, Traficking, dll; </div>
                        </li>
                        <li>
                            <div align="justify"> Memposting, mengerjakan, menjual atau membeli pekerjaan atau produk yang mendiskreditkan atau menyerang Suku, Agama, Ras, Antar Golongan (SARA); </div>
                        </li>
                        <li>
                            <div align="justify"> Mengiklankan situs web di situs {{env('APP_NAME')}}. Setiap URL yang diposting harus berhubungan dengan project di {{env('APP_NAME')}}; </div>
                        </li>
                        <li>
                            <div align="justify"> Meniru website atau sistem {{env('APP_NAME')}}; menyalin, menampilkan, memodifikasi, mendistribusikan, memproduksi, memberi ijin, mentransfer, atau menjual kembali setiap isi, produk dan informasi (termasuk dan tidak terbatas pada; pesan, data, teks, audio, video, foto, grafik, ikon, software atau informasi lainnya), atau jasa yang diperoleh dari atau melalui situs ini; </div>
                        </li>
                        <li>
                            <div align="justify"> Menyalahgunakan hak cipta, hak paten, merek dagang, rahasia dagang, atau hak kekayaan intelektual lainnya atau hak milik atau hak publisitas atau privasi pihak lain;</div>
                        </li>
                        <li>
                            <div align="justify">Membuat kesepakatan di luar {{env('APP_NAME')}} berkaitan dengan project dengan menawarkan transaksi secara langsung, seperti mentransfer langsung ke rekening Pekerja tanpa melalui rekening {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">Menegosiasikan fee atau memberikan layanan gratis kepada pengguna lain, sebelum, selama ataupun sesudah project dikerjakan;</div>
                        </li>
                        <li>
                            <div align="justify">Membocorkan informasi atau dokumen yang diperoleh, kecuali dipersyaratkan oleh hukum atau kewenangan yang diberikan; </div>
                        </li>
                        <li>
                            <div align="justify"> Memberikan tanggapan palsu; </div>
                        </li>
                        <li>
                            <div align="justify"> Memberikan kritikan negatif atau yang tidak sehat, </div>
                        </li>
                        <li>
                            <div align="justify"> Memberikan komentar yang berlebihan atau yang merendahkan pihak lain; </div>
                        </li>
                        <li>
                            <div align="justify"> Terlibat konflik personal atau perlakuan yang tidak profesional; </div>
                        </li>
                        <li>
                            <div align="justify"> Terlibat dalam tindakan penipuan yang dilakukan oleh pengguna lain dan/atau oleh pihak ketiga;</div>
                        </li>
                        <li>
                            <div align="justify">Serta tindakan lainnya yang dirasa mengganggu pihak pengguna lainnya dan/atau pihak {{env('APP_NAME')}}.</div>
                        </li>
                    </ul>
                    <p align="justify">Sebagai akibatnya pengguna yang bersangkutan tidak lagi dapat menggunakan akunnya, akan tetapi akun masih dapat dilihat pada saat browse user, karena semua informasi yang terdapat dalam akun tersebut tetap tersimpan dalam database {{env('APP_NAME')}} </p>
                    <h4>4.5 Penghapusan Akun</h4>
                    <p align="justify">Pengguna yang sudah terdaftar di {{env('APP_NAME')}} tidak dapat menghapus keberadaannya di {{env('APP_NAME')}}, karena {{env('APP_NAME')}} tidak memberlakukan kebijakan penghapusan akun.</p>
                    <h4>4.6 Available Balance</h4>
                    <p align="justify">Setiap dana yang menjadi hak Anda, secara otomatis masuk kedalam available balance pada akun Anda, dana tersebut dapat Anda tarik melalui mekanisme penarikan dana yang sudah ditentukan. {{env('APP_NAME')}} akan melakukan transfer sesuai dengan permintaan Anda dan informasi yang ada dalam akun Anda. <br />
                        Anda mengakui dan setuju bahwa:</p>
                    <ul>
                        <li>
                            <div align="justify">Informasi yang terdapat dalam akun Anda adalah benar;</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} tidak menyediakan layanan perbankan karena {{env('APP_NAME')}} bukan bank atau lembaga keuangan lainnya yang berlisensi; </div>
                        </li>
                        <li>
                            <div align="justify"> {{env('APP_NAME')}} tidak bertindak sebagai wali amanat atau jaminan fidusia sehubungan dengan dana atau pembayaran tersebut;</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} berkewajiban untuk membayarkan sejumlah dana sehubungan dengan transaksi yang telah Anda selesaikan melalui situs {{env('APP_NAME')}} sesuai dengan jumlah dana yang terdapat dalam available balance pada akun Anda, Anda tidak dapat melakukan penarikan dana melebihi dari saldo yang terdapat dalam available balance Anda, sisa saldo yang tersimpan akan diakumulsaikan dengan dana yang akan Anda terima kemudian ke available balance Anda; </div>
                        </li>
                        <li>
                            <div align="justify"> {{env('APP_NAME')}} akan melakukan pembayaran kepada Anda berdasarkan informasi yang Anda berikan;</div>
                        </li>
                        <li>
                            <div align="justify"> {{env('APP_NAME')}} tidak bertanggung jawab terhadap kesalahan transfer yang diakibatkan dari kesalahan pada informasi yang Anda berikan;</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} berhak untuk menangguhkan penarikan dana yang Anda lakukan, jika terdapat dugaan pemalsuan atau indikasi yang meragukan; </div>
                        </li>
                        <li>
                            <div align="justify"> Keterlambatan proses transfer yang di sebabkan oleh perbedaan bank yang Anda pergunakan dengan rekening bank {{env('APP_NAME')}} adalah di luar tanggung jawab {{env('APP_NAME')}}; </div>
                        </li>
                        <li>
                            <div align="justify"> Sejumlah dana yang ditransfer melalui atau disimpan dalam available balance {{env('APP_NAME')}} tidak diasuransikan.</div>
                        </li>
                    </ul>
                    <p align="justify">Anda mengerti dan setuju bahwa {{env('APP_NAME')}} tidak akan menahan dana Anda kecuali bahwa tindakan tersebut diambil untuk kepentingan Anda, tidak ada sedikitpun dari tindakan tersebut dimaksudkan untuk mempersulit ataupun menunda ataupun menghilangkan hak Anda.</p>
                    <h3>5. Produk dan Jasa</strong>
                    </h3>
                    <p align="justify">Produk dan jasa yang tersedia dalam layanan {{env('APP_NAME')}} berupa transaksi project dan transaksi jual beli produk digital;</p>
                    <h4>5.1 Pengiriman Produk</h4>
                    <h5>1) Transaksi Project</h5>
                    <p align="justify">Semua hasil kerja Pekerja di upload ke situs {{env('APP_NAME')}}, sebagai jaminan Klien menerima hasil kerja sesuai dengan yang diinginkan. Klien dapat mendownload hasil kerja Pekerja melalui situs {{env('APP_NAME')}}.<br />
                        Setelah Klien menerima hasil kerja Pekerja, {{env('APP_NAME')}} akan melakukan pembayaran kepada Pekerja sesuai dengan ketentuan yang berlaku.</p>
                    <h5>2) Transaksi Jual Beli Produk Digital</h5>
                    <p align="justify">Semua produk digital yang dibeli buyer akan dikirim kepada buyer melalui akun buyer di situs {{env('APP_NAME')}}. Buyer dapat mendownload produk digiital yang dibelinya setelah buyer meyelesaikan pembayaran.</p>
                    <h5>3) Service</h5>
                    <p align="justify">Semua hasil kerja seller/Pekerja di upload ke situs {{env('APP_NAME')}}, sebagai jaminan buyer/Klien menerima hasil kerja sesuai dengan yang diinginkan. Buyer/Klien dapat mendownload hasil kerja seller/Pekerja melalui situs {{env('APP_NAME')}}.<br />
                        Setelah buyer/Klien menerima hasil kerja seller/Pekerja, {{env('APP_NAME')}} akan melakukan pembayaran kepada seller/Pekerja sesuai dengan ketentuan yang berlaku.</p>
                    <h4>5.2 Garansi</h4>
                    <h5>1) Transaksi Project</h5>
                    <p>Transaksi project memberikan garansi berupa:</p>
                    <ul>
                        <li>
                            <div align="justify">Klien, jaminan pekerjaan selesai atau uang kembali ketika Pekerja tidak dapat menyelesaikan pekerjaannya; </div>
                        </li>
                        <li>
                            <div align="justify">Pekerja, jaminan Pekerja pasti dibayar ketika telah menyelesaikan pekerjaanya;</div>
                        </li>
                        <li>
                            <div align="justify">Arbitrase internal, jika terjadi perselisihan salah satu pihak dapat mengajukan arbitrase melalui Tim Arbitrator {{env('APP_NAME')}}.</div>
                        </li>
                    </ul>
                    <h5>2) Transaksi Jual Beli Produk Digital</h5>
                    <p>Transaksi produk digital memberikan garansi berupa:</p>
                    <ul>
                        <li>
                            <div align="justify">Buyer, jaminan produk digital yang aman dan berkualitas, karena semua produk digital yang di publish pada space penjualan {{env('APP_NAME')}} telah melalui seleksi dan verifikasi oleh Tim Tester {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">Seller, jaminan pembayaran sesuai dengan harga penjualan dan fee produk yang kecil.</div>
                        </li>
                    </ul>
                    <h5>3) Service</h5>
                    <p>Service memberikan garansi berupa:</p>
                    <ul>
                        <li>
                            <div align="justify">Kemudahan bagi seller/Pekerja untuk menawarkan keahliannya pada suatu pekerjaan tertentu, sehingga buyer/Klien dapat dengan mudah mendapatkan kebutuhannya;</div>
                        </li>
                        <li>
                            <div align="justify">Seller/Pekerja, jaminan seller/Pekerja pasti dibayar ketika telah menyelesaikan pekerjaanya;</div>
                        </li>
                        <li>
                            <div align="justify">Buyer/Klien, jaminan pekerjaan selesai atau uang kembali ketika seller/Pekerja tidak dapat menyelesaikan pekerjaannya; </div>
                        </li>
                        <li>
                            <div align="justify">Arbitrase internal, jika terjadi perselisihan salah satu pihak dapat mengajukan arbitrase melalui Tim Arbitrator {{env('APP_NAME')}}.<br />
                            </div>
                        </li>
                    </ul>
                    <h3> 6. Payment</strong> </h3>
                    <h4>6.1 Fasilitas Pembayaran yang Tersedia</h4>
                    <h5>1) Transfer via Rekening Bank</h5>
                    <p>Transfer ke rekening escrow {{env('APP_NAME')}} atas nama PT Panonpoe Media.</p>
                    <ul>
                        <li>
                            <div align="justify">Setiap transaksi yang menggunakan transfer rekening bank akan berstatus disetujui ketika Anda menerima konfirmasi Instruksi Pembayaran dari {{env('APP_NAME')}}. Konfirmasi tersebut akan dikirim melalui email yang telah terdaftar di database {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} akan menindaklanjuti transaksi user, setelah user meyelesaikan Total Pembayaran order, user harus mengirim konfirmasi pembayaran, dengan cara mengklik tombol &quot;<strong>Confirmation Payments</strong>&quot; serta melampirkan bukti pembayaran;</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} akan merelease konfirmasi pembayaran user setiap hari Senin hingga Jum’at jam 09.00 s/d 17.00. Hari Sabtu/Minggu/Libur dan di luar jam operasional tidak melayani konfirmasi pembayaran user;</div>
                        </li>
                        <li>
                            <div align="justify">Pembayaran sudah harus diselesaikan selambat-lambatnya dalam 7x24 jam sejak email &quot;Instruksi Pembayaran&quot; disampaikan;</div>
                        </li>
                        <li>
                            <div align="justify">Jika pembayaran dilakukan setelah 7x24 sejak pemberitahuan Instruksi Pembayaran disampaikan, maka sistem secara otomatis akan meng-cancel tagihan order user. Dana yang telah ditransfer user akan dikembalikan selambat-lambatnya dalam 3 hari kerja sejak user transfer;</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} hanya dapat melindungi Anda jika pembayaran 100% Anda transfer ke rekening escrow {{env('APP_NAME')}} a.n. PT Panonpoe Media.</div>
                            <br />
                        </li>
                    </ul>
                    <h5>2) Transfer via KlikPay/Clickpay/Clicks</h5>
                    <ul>
                        <li>
                            <div align="justify">Sistem pembayaran online ketika pelanggan melakukan pembayaran order secara online dengan menggunakan pilihan sistem pembayaran menggunakan KlikPay/Clickpay/Clicks dan semua transaksi akan diproses dalam mata uang Rupiah&nbsp;Indonesia.<br />
                                Proses pembayaran order Anda kami pastikan aman dengan protokol Secure Sockets Layer (SSL) dimana SSL menyediakan keamanan penuh setiap pengguna dan kebebasan untuk bertransaksi online tanpa rasa khawatir mengenai kemungkinan pencurian informasi;</div>
                        </li>
                        <li>
                            <div align="justify">Pengguna membayar sebagai kesediaan dan persetujuan terhadap pembayaran order pengguna sebesar nilai order tersebut, yang ditandai dengan persetujuan dari bank pemroses untuk melakukan pendebetan pada rekening pengguna;</div>
                        </li>
                        <li>
                            <div align="justify">Pengguna dapat melakukan pembayaran setiap hari (senin sampai minggu) 7x24 jam, termasuk hari libur;</div>
                        </li>
                        <li>
                            <div align="justify">Pengguna kemudian diwajibkan untuk menyelesaikan pembayaran order dan apabila pembayaran order telah berhasil dilakukan, {{env('APP_NAME')}} akan mengirimkan tanda terima pembayaran melalui surat elektronik (e-mail) kepada alamat e-mail pengguna dalam waktu max 1 (satu) hari setelah proses pembayaran order selesai dilakukan;</div>
                        </li>
                        <li>
                            <div align="justify">Pengguna diwajibkan untuk menyimpan bukti pembayaran jika sewaktu-waktu diperlukan dalam proses konfirmasi pembayaran;</div>
                        </li>
                        <li>
                            <div align="justify">Semua transaksi akan diproses dalam kurun waktu 1 x 24 jam;</div>
                        </li>
                        <li>
                            <div align="justify">Bank pemroses kartu berhak menolak transaksi pengguna. </div>
                        </li>
                    </ul>
                    <h6>A. Prosedur Pembayaran via KlikPay/Clickpay/Clicks</h6>
                    <p align="justify">Pengguna login ke situs {{env('APP_NAME')}}, bagi pengguna yang belum terdaftar wajib registrasi terlebih dahulu untuk dapat login dan bertransaksi pada situs {{env('APP_NAME')}}. Setelah login berhasil, maka pengguna dapat melakukan transaksi di {{env('APP_NAME')}}.</p>
                    <p align="justify">Semua transaksi yang terjadi dapat dilihat pada menu <strong>Shopping Cart</strong>, untuk melanjutkan transaksi pengguna harus mengklik <strong>Checkout</strong> dan memilih pembayaran secara online, dengan menggunakan KlikPay/Clickpay/Clicks pada salah satu bank penyedia, pengguna akan menerima konfirmasi sebagai berikut:</p>
                    <ul>
                        <li>
                            <div align="justify">Memasukan ID dan Password;</div>
                        </li>
                        <li>
                            <div align="justify">Summary Payment, berisi tentang Merchant dan detail transaksi pengguna;</div>
                        </li>
                        <li>
                            <div align="justify">Input kode informasi yang diberikan bank penyedia melalui fasilitas yang sudah ditentukan oleh bank penyedia;</div>
                        </li>
                        <li>
                            <div align="justify">Setelah melakukan verifikasi bank penyedia mendebet rekening Nasabah, mengkreditkan ke rekening penampungan {{env('APP_NAME')}}, dan mengirimkan konfirmasi berhasil ke {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} menampilkan layar konfirmasi transaksi berhasil ke pengguna.</div>
                            <br />
                        </li>
                    </ul>
                    <h6>B. Biaya Pemrosesan KlikPay/Clickpay/Clicks</h6>
                    <p align="justify">{{env('APP_NAME')}} mengenakan biaya pemrosesan kepada pengguna sebesar Rp 5.000,- hingga Rp 10.000,- bergantung dari bank penyedia.</p>
                    <h5>3) Transfer via Kartu Kredit (Visa dan MasterCard)</h5>
                    <ol>
                        <ul>
                            <li>
                                <div align="justify">Untuk memberikan kemudahan dan kepastian bagi pelanggan dalam melakukan transaksi pada situs {{env('APP_NAME')}}, saat ini kami telah mengimplementasikan suatu sistem pembayaran online ketika pelanggan melakukan pembayaran order secara online dengan menggunakan pilihan sistem pembayaran dari Visa/Master&nbsp;dan semua transaksi akan diproses dalam mata uang Rupiah&nbsp;Indonesia.<br />
                                    Proses pembayaran order Anda kami pastikan aman dengan protokol Secure Sockets Layer (SSL) dimana SSL menyediakan keamanan penuh setiap pelanggan dan kebebasan untuk bertransaksi online tanpa rasa khawatir mengenai kemungkinan pencurian informasi kartu kredit;</div>
                            </li>
                            <li>
                                <div align="justify">Pengguna membayar sebagai kesediaan dan persetujuan terhadap pembayaran order pengguna sebesar nilai order tersebut, yang ditandai dengan persetujuan dari bank pemroses kartu yang telah melakukan pendebetan;</div>
                            </li>
                            <li>
                                <div align="justify">Pengguna dapat melakukan pembayaran setiap hari (senin sampai minggu) 7x24 jam, termasuk hari libur;</div>
                            </li>
                            <li>
                                <div align="justify">
                                    <div align="justify">Pengguna kemudian diwajibkan untuk menyelesaikan pembayaran order dan apabila pembayaran order telah berhasil dilakukan, {{env('APP_NAME')}} akan mengirimkan tanda terima pembayaran melalui surat elektronik (e-mail) kepada alamat e-mail pengguna dalam waktu max 1 (satu) hari setelah proses pembayaran order selesai dilakukan.</div>
                                </div>
                            </li>
                            <li>
                                <div align="justify">Pengguna diwajibkan untuk menyimpan bukti pembayaran jika sewaktu-waktu diperlukan dalam proses konfirmasi pembayaran.</div>
                            </li>
                            <li>
                                <div align="justify">Semua transaksi akan diproses dalam kurun waktu 1 x 24 jam.</div>
                            </li>
                            <li>
                                <div align="justify">Bank pemroses kartu berhak menolak transaksi user. </div>
                            </li>
                        </ul>
                    </ol>
                    <h6>A. Prosedur Pembayaran via Kartu Kredit</h6>
                    <p align="justify">User login ke situs {{env('APP_NAME')}}. Bagi user yang belum terdaftar wajib registrasi terlebih dahulu untuk dapat login dan bertransaksi pada situs {{env('APP_NAME')}}
                        b. Setelah login berhasil, maka user dapat melakukan transaksi project dan/atau transaksi pembelian produk digital.</p>
                    <p align="justify">Semua transaksi yang terjadi dapat dilihat pada menu <strong>Shopping Cart</strong>, untuk melanjutkan transaksi user harus mengklik <strong>Checkout</strong> dan memilih pembayaran secara online, dengan meng-klik <strong>Pay with Credit Card</strong>, user akan menerima konfirmasi sebagai berikut:</p>
                    <p>a) Order Detail, berisi:</p>
                    <ul>
                        <li>Invoice number:
                            <ul>
                                <li>Item Description</li>
                                <li>Unit Price</li>
                            </ul>
                        </li>
                        <li>Payment Method</li>
                    </ul>
                    <p>b) Melakukan verifikasi melaui website {{env('APP_NAME')}}, dengan parameter sbb:</p>
                    <ul>
                        <li>Name</li>
                        <li> Address</li>
                        <li> Email</li>
                        <li>City</li>
                        <li>Region/State</li>
                        <li>Postal Code</li>
                        <li>Country</li>
                        <li>Mobile Phone</li>
                        <li>Home Phone/Work Phone</li>
                    </ul>
                    <p>c) Process Payment atau Cancel</p>
                    <ul>
                        <li>Approve
                            <ul>
                                <li>
                                    <div align="justify">Merchan akan mengirimkan email dan SMS konfirmasi yang isinya berupa pemberitahuan kepada user (buyer) telah bisa mendownload pembelian produk digiitalnya dan/atau user (Klien) project telah bisa mulai dikerjakan;</div>
                                </li>
                                <li>
                                    <div align="justify">Order Complete.<br />
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>Failed
                            <ul>
                                <li>
                                    <div align="justify">Merchant akan melakukan void atas transaksi user tersebut dengan cara men-select &ldquo;void&rdquo; pada halaman Back Admin Merchant, dengan mengirimkan email konfirmasi ke alamat email user sebagaimana yang terdaftar pada database {{env('APP_NAME')}}, berikut alasan penolakan (void) atas transaksi tersebut.</div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <h6>B. Biaya Pemrosesan Kartu Kredit</h6>
                    <p align="justify">{{env('APP_NAME')}} mengenakan biaya pemrosesan kepada user sebesar 3,25% + Rp 3.500,- dengan minimal biaya pemrosesan sebesar Rp 10.000,- (jika 3,25% + Rp 3.500,- kurang dari Rp 10.000,- maka akan dibulatkan menjadi Rp 10.000,-). </p>
                    <h4>6.2 Total Tagihan</h4>
                    <ul>
                        <li>
                            <div align="justify">Total tagihan yang harus dibayarkan adalah sebagaimana yang tertera pada Shopping Cart (keranjang belanja) dan/atau invoice pemesanan (halaman Order Details);</div>
                        </li>
                        <li>
                            <div align="justify">Apabila terjadi perubahan harga produk digital, maka harga yang berlaku adalah harga yang sesuai dengan informasi total belanja yang ditampilkan dalam Order Details.</div>
                        </li>
                    </ul>
                    <h4 data-toc-text="6.3 Antisipasi Penyalahgunaan Pembayaran">6.3 Antisipasi Penyalahgunaan Kartu Kredit/KlikPay/Clickpay/Clicks pada Transaksi Online</h4>
                    <h5>1) Antisipasi via Situs</h5>
                    <ul>
                        <li>
                            <div align="justify">User wajib melakukan registrasi sebagai member pada situs {{env('APP_NAME')}} dengan memberikan informasi lengkap mengenai data diri dan jenis kartu yang digunakan ketika melakukan pembayaran melalui kartu kredit/KlikPay/Clickpay/Clicks.</div>
                        </li>
                        <li>
                            <div align="justify">Setiap akun user telah dilengkapi password yang berisi kombinasi menggunakan huruf besar, huruf kecil dan angka, guna menjamin keamanan akun user yang bersangkutan.</div>
                        </li>
                    </ul>
                    <h5>2) Antisipasi via Telepon</h5>
                    <p align="justify">Bank pemroses kartu kredit/KlikPay/Clickpay/Clicks akan melakukan verifikasi melalui nomor telepon yang telah didaftarkan user pada bank pemroses kartu kredit/KlikPay/Clickpay/Clicks, untuk memastikan bahwa user yang bersangkutan adalah pemilik kartu kredit/KlikPay/Clickpay/Clicks yang melakukan transaksi secara online.</p>
                    <h3> 7. Pengembalian Dana (Refund)</h3>
                    <ul>
                        <li>
                            <div align="justify">Pengembalian dana hanya berlaku untuk transaksi open project maupun private project;</div>
                        </li>
                        <li>
                            <div align="justify">Besaran atau jumlah dana yang dikembalikan adalah sebagaimana hasil kesepakatan antara pengguna atau berdasarkan keputusan arbitrase yang ditetapkan oleh tim arbitrator {{env('APP_NAME')}}; </div>
                        </li>
                        <li>
                            <div align="justify">Dana akan dikreditkan/dimasukan ke available balance akun pengguna di {{env('APP_NAME')}};</div>
                        </li>
                        <li>
                            <div align="justify">Pengguna dapat menarik available balance tersebut melalui mekanisme withdrawal yang sudah ditentukan;</div>
                        </li>
                        <li>
                            <div align="justify">Pengguna juga dapat menggunakan available balance tersebut untuk kepentingan transaksi di {{env('APP_NAME')}} dalam pembuatan project atau pembelian produk digital;</div>
                        </li>
                        <li>
                            <div align="justify">Proses withdrawal sebagaimana yang dijelaskan di dalam pasal 8 perjanjian pengguna;</div>
                        </li>
                        <li>
                            <div align="justify"> {{env('APP_NAME')}} berhak untuk melakukan perubahan mekanisme refund atau pengembalian dana tanpa kewajiban pemberitahuan sebelumnya.</div>
                            <br />
                        </li>
                    </ul>
                    <h3>8. Penarikan Dana</strong>
                    </h3>
                    <h4>8.1 Cara Penarikan Dana</h4>
                    <p align="justify">Setiap dana yang Anda hasilkan di {{env('APP_NAME')}} secara otomatis akan langsung dikreditkan ke available balance akun Anda di {{env('APP_NAME')}}, selanjutnya {{env('APP_NAME')}} akan mentransfer dana Anda dari available balance ke rekening bank Anda sesuai dengan setting payment yang sudah Anda buat sebelumnya. Anda dapat melakukan setting penarikan dana melalui menu:</p>
                    <p align="justify"><strong>My Account &gt; My Finance &gt; Change Payment Settings</strong>.</p>
                    <p align="justify">Demi keamanan dana Anda
                        {{env('APP_NAME')}} akan melakukan verifikasi rekening Anda malalui email dan sms dengan secure code tertentu, untuk itu Anda harus memasukan email dan nomor telepon seluler Anda dengan benar.<br />
                        Uang ditransfer ke rekening bank Anda, selambat-lambatnya dalam 3 (tiga) hari kerja, sejak Anda melakukan penarikan. </p>
                    <h4>8.2 Ketentuan Penarikan Dana</h4>
                    <p align="justify">{{env('APP_NAME')}} akan mentransfer dana dari rekening bank {{env('APP_NAME')}} ke rekening bank Anda dengan ketentuan sebagai berikut:</p>
                    <div align="justify">
                        <ul>
                            <li>Anda wajib melampirkan identitas yang benar dan mencantumkan/mendaftarkan informasi rekening bank milik Anda dengan benar di situs {{env('APP_NAME')}}.</li>
                            <li>Anda tidak dapat meminta kepada {{env('APP_NAME')}} untuk mentransfer dana ke rekening Anda yang tidak terdaftar di {{env('APP_NAME')}}.</li>
                            <li>{{env('APP_NAME')}} tidak bertanggung jawab atas kehilangan dana yang diakibatkan oleh kesalahan informasi rekening yang Anda daftarkan<strong> </strong>di situs {{env('APP_NAME')}}. </li>
                        </ul>
                    </div>
                    <h4>8.3 Batasan Penarikan Dana</h4>
                    <p align="justify">Anda dapat melakukan penarikan dana dari available balance Anda di {{env('APP_NAME')}} ke rekening bank Anda, setiap hari kerja (senin-Jum&rsquo;at) dari jam 09.00-15.00 WIB, adapun nominal penarikan yang bisa dilakukan, adalah sebesar:</p>
                    <h5>1) Minimal Penarikan</h5>
                    <ul>
                        <li>
                            <div align="justify">Minimal Rp 10.000,- (sepuluh ribu rupiah) untuk pengguna Bank BCA, BNI, BNI Syari'ah, Mandiri dan CIMB Niaga;</div>
                        </li>
                        <li>
                            <div align="justify">Minimal Rp 57.500,- (limapuluhtujuh ribu limaratus rupiah) untuk pengguna selain Bank tersebut di atas (Rp 50.000,- + biaya transfer Rp 7.500,-).</div>
                        </li>
                    </ul>
                    <h5>2) Maksimal Penarikan</h5>
                    <ul>
                        <li>
                            <div align="justify">Maksimal Rp. 100.000.000,- (seratusjuta rupiah) untuk satu kali penarikan, ditambah biaya transfer sebesar Rp 25.000,- (duapuluhlima ribu rupiah).
                            </div>
                        </li>
                    </ul>
                    <h3> 9. Fee dan Biaya</h3>
                    <p align="justify">Kami yakin dan percaya fee yang kami kenakan merupakan kebijakan profesional dalam semua proses transaksi bisnis demi terselenggaranya sistem kerja yang adil dan berkesinambungan dan dibenarkan secara hukum, oleh karena itu kami tidak mentolerir setiap upaya dari salah satu pihak didalam menegosiasikan fee atau bahkan untuk memberikan layanan gratis kepada pengguna lain.</p>
                    <h4>9.1 Fee Project</h4>
                    <p align="justify">{{env('APP_NAME')}} mengenakan fee kepada Pekerja sebesar 12% (duabelas persen) dari harga project sebelum dipotong pajak (PPh dan/atau PPN).</p>
                    <h4>9.2 Fee Product</h4>
                    <p align="justify">{{env('APP_NAME')}} mengenakan fee kepada seller sebesar 20% (duapuluh persen) dari harga produk sebelum dipotong pajak (PPh dan/atau PPN).</p>
                    <h4>9.3 Fee Service</h4>
                    <p align="justify">{{env('APP_NAME')}} mengenakan fee kepada seller/Pekerja sebesar 12% (duabelas persen) dari harga service sebelum dipotong pajak (PPh dan/atau PPN).</p>
                    <h4>9.4 Biaya Transfer</h4>
                    <p align="justify">Biaya transfer dikenakan kepada pengguna pada setiap proses transfer dari rekening {{env('APP_NAME')}} ke rekening bank pengguna, dengan ketentuan:</p>
                    <ul>
                        <li>
                            <div align="justify">Gratis biaya transfer untuk pengguna Bank BCA, BNI, BNI Stari'ah, Mandiri dan CIMB Niaga;</div>
                        </li>
                        <li>
                            <div align="justify">Biaya transfer Rp. 7.500,- (tujuhribu limaratus rupiah) untuk pengguna selain Bank tersebut di atas.</div>
                        </li>
                    </ul>
                    <h4>9.5 Biaya Tanda Terima</h4>
                    <p align="justify">Biaya tanda terima adalah biaya berdasarkan permintaan pengguna dari transaksi yang terjadi. Biaya tanda terima ditanggung oleh pengguna yang yang melakukan permintaaan &ldquo;Tanda Bukti Pembayaran&rdquo; terhadap sejumlah biaya yang ditransfer pengguna ke rekening {{env('APP_NAME')}}.</p>
                    <p align="justify"> Tanda terima akan dikirim oleh {{env('APP_NAME')}} kepada pengguna melalui jasa pos atau kurir, setelah pengguna yang bersangkutan mentransfer biaya tanda terima ke rekening {{env('APP_NAME')}}. Besaran <strong>Biaya Tanda Terima</strong> sebesar Rp 15.000 (lima belas ribu rupiah) sudah termasuk biaya materai dan ongkos kirim. </p>
                    <p align="justify">Selain dari yang telah disebutkan diatas, tidak ada lagi biaya lain yang dipungut {{env('APP_NAME')}} kepada pengguna.</p>
                    <h3> 10. Pajak</h3>
                    <h4>10.1 Pajak Penghasilan (PPh)</h4>
                    <ul>
                        <li>
                            <div align="justify">Dikenakan kepada Seller dan/atau Pekerja sebagai pribadi atau badan yang memperoleh penghasilan dari penjualan barang dan/atau penyediaan jasa yang penghasilannya tidak dikenakan pajak yang bersifat final, tarif PPh pasal 17 Undang-Undang PPh diterapkan atas Penghasilan Kena Pajak yang dihitung dari penghasilan bruto dari penjualan barang dan/atau penyediaan jasa yang dikurangi dengan biaya-biaya untuk mendapatkan, menagih dan memelihara penghasilan; </div>
                        </li>
                        <li>
                            <div align="justify">Apabila buyer dan/atau Klien adalah Wajib Pajak Orang Pribadi atau Badan yang ditunjuk sebagai pemotong/pemungut PPh, maka buyer dan/atau Klien<strong> </strong>tersebut wajib melakukan pemotongan/pemungutan PPh dengan tarif dan tata cara sesuai dengan ketentuan yang berlaku.</div>
                        </li>
                    </ul>
                    <h4>10.2 Pajak Pertambahan Nilai (PPN)</h4>
                    <ul>
                        <li>
                            <div align="justify">Penyerahan produk digital yang dilakukan seller kepada buyer melalui {{env('APP_NAME')}} dan/atau penyerahan hasil pekerjaan yang dilakukan Pekerja kepada Klien melalui {{env('APP_NAME')}} dianggap sebagai penyerahan Barang Kena Pajak (BKP) yang terhutang PPN sebesar 10% sebagaimana diatur pada Pasal 1A huruf c Undang-Undang No. 42 tahun 2009 tentang PPN dan PPnBM;</div>
                        </li>
                        <li>
                            <div align="justify">Berkaitan dengan PPN ini Seller dan/atau Pekerja wajib mengeluarkan faktur pajak kepada buyer dan/atau Klien;</div>
                        </li>
                        <li>
                            <div align="justify">Dalam hal seller dan/atau Pekerja bukan Pengusaha Kena Pajak (PKP) maka Seller dan/atau Pekerja<strong> </strong>tidak menerbitkan faktur pajak.</div>
                            <br />
                        </li>
                    </ul>
                    <h3> 11. Keterbatasan dan Pengecualian</h3>
                    <p align="justify">{{env('APP_NAME')}} telah menerapkan langkah-langkah teknis dan sistemis yang dirancang untuk mengamankan informasi pribadi pengguna dari perbuatan pihak ketiga yang mungkin dapat merugikan pengguna seperti, pengaksesan yang tidak sah, menggunakan informasi pribadi pengguna untuk tujuan yang tidak benar, mengubah atau membocoran informasi. Namun kami tidak dapat menjamin kemampuan pihak ketiga yang secara sengaja atau tidak, mampu mengalahkan langkah-langkah teknis dan sistemis yang kami buat. Untuk itu Anda juga bertanggung jawab untuk menjaga, memelihara dan penyimpanan catatan bisnis demi menghindari hal-hal yang tidak diinginkan. <br />
                        Anda mengakui bahwa Anda memberikan informasi pribadi Anda, atau informasi tentang entitas yang Anda wakili dengan resiko yang tersebut. </p>
                    <h3> 12. Batasan Tanggung Jawab</h3>
                    <p align="justify">Dalam hal sengketa yang mungkin terjadi, {{env('APP_NAME')}}, afiliasinya dan staff tidak bertanggung jawab dalam hal kesalahan ataupun kelalaian, seperti:</p>
                    <ul>
                        <li>
                            <div align="justify">Kesalahan atau kelalaian yang secara langsung ataupun tidak langsung dirasa mengganggu kepentingan pihak lain yang mungkin timbul oleh Anda; </div>
                        </li>
                        <li>
                            <div align="justify"> Hilangnya project, pendapatan atau keuntungan (baik langsung atau tidak langsung ) yang mungkin timbul oleh Anda; </div>
                        </li>
                        <li>
                            <div align="justify"> Kerugian yang timbul sebagai akibat dari klaim, tuntutan atau kerusakan yang dapat ditanggung oleh Anda sebagai akibat dari kesalahan atau kelalaian Anda; </div>
                        </li>
                        <li>
                            <div align="justify"> {{env('APP_NAME')}}, afiliasi dan staff tidak berkewajiban memberitahukan kepada Anda mengenai kerugian atau kerusakan yang mungkin timbul.</div>
                        </li>
                    </ul>
                    <p align="justify">Tidak ada dalam Perjanjian ini dimaksudkan untuk membatasi atau mengecualikan kewajiban apapun dari {{env('APP_NAME')}} kepada Anda kecuali bahwa pengecualian atau pembatasan tersebut dibenarkan oleh hukum yang berlaku.</p>
                    <h3>13. Ganti Rugi</h3>
                    <p align="justify">{{env('APP_NAME')}} dan afiliasinya tidak bertanggung jawab terhadap kerugian, biaya, pengeluaran, kerusakan atau kewajiban lainnya (termasuk biaya pengacara) yang timbul dari atau berhubungan dengan setiap penyebab tindakan, klaim, gugatan, banding, permintaan atau tindakan yang dibawa oleh pihak ketiga.</p>
                    <p align="justify"> Kerugian, biaya, pengeluaran, kerusakan atau kewajiban lainnya (termasuk biaya pengacara) yang timbul dari atau berhubungan dengan setiap penyebab tindakan, klaim, gugatan, banding, permintaan atau tindakan yang dibawa oleh pihak ketiga sepenuhnya merupakan tanggung jawab pengguna yang bersengketa.</p>
                    <h3>14. Jangka Waktu Perjanjian</h3>
                    <p align="justify">Perjanjian ini akan menjadi efektif setelah proses registrasi Anda ke website {{env('APP_NAME')}} dan selama Anda mengunjungi atau menggunakan situs kami. </p>
                    <p align="justify"> {{env('APP_NAME')}} dapat mengeluarkan peringatan, atau menghentikan sementara akun Anda tanpa batas waktu atau menghentikan akses pengguna Anda dan menolak untuk memberikan layanan situs untuk Anda, jika Anda:</p>
                    <ul>
                        <li>
                            <div align="justify">Melanggar syarat dan ketentuan Perjanjian ini; </div>
                        </li>
                        <li>
                            <div align="justify"> Kami menduga atau mengetahui bahwa Anda telah memberikan informasi palsu; atau </div>
                        </li>
                        <li>
                            <div align="justify"> Kami menduga atau mengetahui bahwa Anda menngunakan situs kami bertentangan dengan kepentingan situs atau dengan komunitas pengguna {{env('APP_NAME')}}.</div>
                        </li>
                    </ul>
                    <p align="justify">Pelanggaran perjanjian ini dapat dituntut hukum sepenuhnya dan dapat mengakibatkan hukuman tambahan dan sanksi. Kami akan mengirimkan pemberitahuan kepada Anda jika kami menonaktifkan keanggotaan Anda, kecuali menurut penilaian kami memberikan pemberitahuan akan menyebabkan resiko pelanggaran lebih lanjut. Namun, kami akan memberitahu Anda bahwa akun Anda dibatalkan jika hukum memerlukan notifikasi.</p>
                    <p align="justify">Pemutusan akun akan secara otomatis memberikan hak kepada {{env('APP_NAME')}} untuk menghentikan semua rekening yang terkait dari akun Anda.</p>
                    <h3>15. Sengketa</h3>
                    <h4>15.1 Sengketa Antara Pengguna</h4>
                    <p align="justify">Dalam hal penyelesaian persengketaan yang terjadi antara Anda dengan pengguna lain bahwa Anda setuju untuk menyelesaikan setiap perbedaan yang terjadi termasuk dalam kaitannya dengan kualitas dan layanan yang diberikan. Anda setuju dan mengakui bahwa:</p>
                    <ul>
                        <li>
                            <div align="justify">{{env('APP_NAME')}} hanya akan memediasi kepada kedua belah pihak berdasarkan data dan dokumen yang ada melalui arbitrase;</div>
                        </li>
                        <li>
                            <div align="justify">Segala komunikasi antara harus dilakukan di situs {{env('APP_NAME')}}, baik menggunakan thread maupun menggunakan fasilitas real-time chat yang telah disediakan;</div>
                        </li>
                        <li>
                            <div align="justify">Jika Anda melakukan pembicaraan diluar situs {{env('APP_NAME')}} maka {{env('APP_NAME')}} tidak memiliki catatan (log) pembicaraan Anda. Ketika terjadi sengketa dan salah satu pihak mengajukan arbitrase, hanya pembicaraan dalam situs {{env('APP_NAME')}} yang dapat diajukan sebagai bukti;</div>
                        </li>
                        <li>
                            <div align="justify"> {{env('APP_NAME')}} tidak menyediakan layanan dan nasehat hukum; </div>
                        </li>
                        <li>
                            <div align="justify"> Atas penolakan Anda terhadap hasil keputusan arbitrase oleh tim arbitrator {{env('APP_NAME')}}, Anda diperbolehkan memilih penyelesaian perselisihan secara abitrase di Jakarta sesuai dengan ketentuan dan peraturan BANI (Badan Arbitrase Nasional Indonesia); </div>
                        </li>
                        <li>
                            <div align="justify"> Tim arbitrator {{env('APP_NAME')}} hanya akan bertindak sebagai saksi ahli jika diperlukan;</div>
                        </li>
                        <li>
                            <div align="justify">Dengan adanya sengketa atau perselisihan ini yang berakibat pada adanya akibat hukum bagi {{env('APP_NAME')}} secara perdata maupun pidana, pengguna setuju untuk mengambil alih dan membebaskan {{env('APP_NAME')}} dari segala akibat hukum tersebut. </div>
                        </li>
                        <li>
                            <div align="justify"> Anda diperbolehkan memiliki penasihat hukum yang berlisensi sebagai penasehat hukum Anda. Kerugian, biaya, pengeluaran, kerusakan atau kewajiban lainnya (termasuk biaya pengacara) yang timbul dari atau berhubungan dengan setiap penyebab tindakan, klaim, gugatan, banding atau permintaan sepenuhnya merupakan tanggung jawab Anda.</div>
                        </li>
                    </ul>
                    <h4>15.2 Sengketa Antara Pengguna Dengan {{env('APP_NAME')}}</h4>
                    <p align="justify">Jika timbul sengketa antara pengguna dengan {{env('APP_NAME')}} maka sengketa akan diselesaikan secara cepat hingga kedua pihak yang bersengketa mendapat putusan yang jelas. Oleh karena itu, jika dalam kurun waktu selambat-lambatanya 30 (tiga puluh) hari sejak persengketaan terjadi antara Anda dan {{env('APP_NAME')}}, Anda setuju bahwa {{env('APP_NAME')}} akan menyelesaikan setiap klaim, tuntutan atau perbedaan yang terjadi antara Anda dengan {{env('APP_NAME')}} melalui hukum peradilan yang berlaku dengan atau tanpa pemberitahuan terlebih dahulu, maka dengan adanya pernyataan tertulis dari salah satu pihak kepada pihak lainnya bahwa perselisihan tidak dapat diselesaikan, maka salah satu pihak dapat berinisiatif untuk menyelesaikan perselisihan secara arbitrase di Jakarta sesuai dengan ketentuan dan peraturan BANI (Badan Arbitrase Nasional Indonesia).</p>
                    <h4>15.3 Arbitrase</h4>
                    <p align="justify">{{env('APP_NAME')}} memiliki hak penuh untuk mengambil tindakan terhadap semua persengketaan yang terjadi. Anda mengakui bahwa {{env('APP_NAME')}} bukanlah lembaga peradilan yang bertanggung jawab dalam penyelesaian persengketaan dan bahwa {{env('APP_NAME')}} hanya akan membuat penentuan yang wajar berdasarkan dokumen yang didapat. Anda setuju bahwa {{env('APP_NAME')}} memiliki kebijakan mutlak untuk menerima atau menolak dokumen yang Anda berikan, sehingga dalam hal ini tim arbitrator hanya akan menggunakan file yang berasal dari sistem pesan pribadi project Klien maupun Pekerja yang bersengketa, yang terdapat pada situs {{env('APP_NAME')}} sebagai dokumen tunggal dalam arbitrase. Selain itu, {{env('APP_NAME')}} tidak menjamin bahwa dokumen-dokumen yang disediakan oleh pihak yang bersengketa, yang berasal dari luar sistem {{env('APP_NAME')}} adalah benar, lengkap dan valid.</p>
                    <p align="justify"> Anda harus memiliki alasan kuat mengapa Anda mengajukan arbitrase, jika Anda memiliki alasan dan bukti yang tidak kuat bisa jadi Anda akan mengalami kerugian sebagai akibat dari dokumentasi yang tidak benar, tidak lengkap dan tidak valid, Anda akan dikenakan penalti yang dapat mencederai reputasi Anda yang dapat memberikan dampak jangka panjang terhadap kesuksesan Anda di {{env('APP_NAME')}}, dan Anda juga setuju untuk membayar kerugian yang mungkin timbul sebagai akibat dari setiap klaim, tuntutan, dan kerusakan yang Anda ajukan dalam peradilan, sebagaimana yang disebutkan dalam pasal (13).</p>
                    <p align="justify"> Jika Anda mengalami kesulitan atau masalah sehubungan dengan persengketaan dengan pengguna lain dalam kaitannya dengan project, kami sarankan Anda untuk menghubungi kami sebagaimana diatur dalam Pasal (19). </p>
                    <h4>15.4 Tim Arbitrator</h4>
                    <p align="justify">Tim arbitrator {{env('APP_NAME')}} memiliki hak yang bersifat final, mengikat, dan tidak dapat diubah. Tim arbitrator berhak untuk mengambil alih persengketaan yang diajukan salah satu pihak dengan atau tanpa pemberitahuan terlebih dulu kepada Anda, Anda setuju dan mengakui bahwa:</p>
                    <ul>
                        <li>
                            <div align="justify">Putusan tim arbitrator {{env('APP_NAME')}} adalah sah dan dibenarkan berdasarkan perjanjian ini; </div>
                        </li>
                        <li>
                            <div align="justify">Tim arbitrator dan {{env('APP_NAME')}} dengan ini tidak berkewajiban atas kerugian yang disebabkan oleh klaim, tuntutan dan kerusakan yang terjadi. </div>
                        </li>
                    </ul>
                    <h4>15.5 Prosedur Penyelesaian Sengketa </h4>
                    <h5>1) Proses Indentifikasi Masalah</h5>
                    <p align="justify">Adanya pengaduan dari salah satu pihak terhadap project yang sedang berlangsung. Penggugat mengisi formulir arbitrase yang telah disediakan yang berisikan; identitas project, identifikasi pihak tergugat, uraian masalah berupa penjelasan mengapa sengketa diajukan atas dasar hukum dan faktual sengketa, juga harapan yang dikehendaki sebagai solusi dari sengketa yang terjadi. Selanjutnya formulir gugatan dikirimkan kepada pihak tergugat.</p>
                    <p align="justify">Pihak tergugat mempunyai waktu selambat-lambatnya 3x24 jam sejak pemberitahuan arbitrase disampaikan, untuk memberikan jawaban balasan terhadap surat gugatan, jika dalam kurun waktu lebih dari 3x24 jam sejak pemberitahuan arbitrase disampaikan, pihak tergugat belum memberikan jawaban balasan, tim arbitrator akan melakukan panggilan kepada pihak tergugat.<br />
                        Tim arbitrator hanya akan memberikan panggilan kepada pihak tergugat sebanyak 3 (tiga) kali panggilan, jika pihak tergugat tidak memberikan balasan:</p>
                    <ul>
                        <li>
                            <div align="justify">Panggilan Pertama, setelah 3x24 jam sejak pemberitahuan arbitrase disampaikan; </div>
                        </li>
                        <li>
                            <div align="justify">Panggilan kedua, setelah 2x24 jam sejak panggilan pertama disampaikan;</div>
                        </li>
                        <li>
                            <div align="justify">Panggilan ketiga, setelah 1x24 jam sejak panggilan kedua disampaikan;</div>
                        </li>
                        <li>
                            <div align="justify">Pengambilalihan arbitrase oleh tim arbitrator {{env('APP_NAME')}}, setelah 1x24 jam sejak panggilan ketiga disampaikan.</div>
                        </li>
                    </ul>
                    <p align="justify">{{env('APP_NAME')}} akan memberikan penalti berupa pengurangan poin reputasi sebesar -2 (minus dua) poin dikali nilai project dibagi seratus ribu (-2 * nilai project /100.000) untuk setiap pemanggilan yang terjadi kepada pihak tergugat.</p>
                    <p align="justify">Jika sampai dengan panggilan ketiga, pihak tergugat tidak juga memberikan jawaban balasan, maka proses arbitrase akan diambil alih oleh tim arbitrator {{env('APP_NAME')}}, selanjutnya tim akan memberikan putusan terhadap sengketa yang terjadi. Tim arbitrator hanya akan menggunakan file yang berasal dari sistem pesan pribadi project penggugat maupun tergugatyang terdapat pada situs {{env('APP_NAME')}} sebagai dokumen tunggal dalam arbitrase.</p>
                    <p align="justify">Penggugat sadar bahwa dengan mengirim formulir gugatan ini, penggugat bersedia menanggung resiko yang mungkin timbul, untuk memberikan ganti rugi sebagai akibat dari klaim, tuntutan dan kerusakan yang terjadi.</p>
                    <p align="justify">Identifikasi masalah bertujuan agar masing-masing pihak bisa saling mengetahui dan memahami permasalah dan keinginan pihak lain. </p>
                    <h5>2) Proses Negosiasi</h5>
                    <p align="justify">Kedua belah pihak diberi kesempatan untuk mencari solusi bersama, selambat-lambatnya dalam kurun waktu 3x24 jam terhitung sejak pihak tergugat mengirimkan jawaban balasan arbitrase.</p>
                    <p align="justify">Pembatalan sengketa hanya dapat dilakukan oleh pihak penggugat, atau adanya kesepakatan bersama antara penggugat dan tergugat sebelum masa negosiasi berakhir. Jika tidak mendapatkan kesepakatan hingga masa negosiasi berakhir, maka sengketa atau arbitrase akan diambil alih oleh tim arbitrator {{env('APP_NAME')}}. </p>
                    <h5>3) Proses Pengambilan Keputusan (Decided)</h5>
                    <p align="justify">Jika sampai dengan panggilan ke tiga pihak tergugat tidak memberikan respon maka keputusan arbitrase secara otomatis akan diambil alih oleh tim arbitrator {{env('APP_NAME')}}.</p>
                    <p align="justify">Atau jika terdapat suatu keadaan tertentu dimana pihak penggugat dikarenakan sesuatu dan lain hal meminta kepada {{env('APP_NAME')}} agar sengketa atau arbitrase bisa segera diselesaikan maka tim arbitrator {{env('APP_NAME')}} dapat mengambil alih arbitrase dengan ketentuan jika dalam masa pengaduan 3x24 jam tersebut pihak tergugat tidak memberikan respon atau tanggapan terhadap pengaduan pihak penggugat. {{env('APP_NAME')}} melalui tim arbitrator tidak berkewajiban untuk memberikan konfirmasi terlebih dahulu kepada pihak tergugat.</p>
                    <p align="justify">Tim arbitrator akan memberikan putusan terhadap sengketa selambat-lambatnya 3 hari kerja, sejak sengketa diambil alih oleh tim arbitrator. Putusan tim arbitrator bersifat final, mengikat, dan tidak dapat diubah.</p>
                    <p align="justify"> Anda setuju jika dalam kurun waktu selambat-lambatnya 30 (tiga puluh) hari sejak putusan arbitrase ditetapkan oleh tim arbitrator {{env('APP_NAME')}}, Anda menolak putusan tim arbitrator {{env('APP_NAME')}}, maka dengan adanya pernyataan tertulis dari Anda kepada tim arbitrator {{env('APP_NAME')}} dan kepada pihak lainnya bahwa perselisihan tidak dapat diselesaikan, maka Anda dapat menyelesaikan perselisihan secara arbitrase di Jakarta sesuai dengan ketentuan dan peraturan BANI (Badan Arbitrase Nasional Indonesia). Tim arbitrator {{env('APP_NAME')}} akan bertindak sebagai saksi ahli jika diperlukan.</p>
                    <h3>16. Pemberitahuan</h3>
                    <p align="justify">Anda setuju untuk menerima pemberitahuan dari kami secara elektronik dan Anda setuju bahwa komunikasi elektronik memenuhi segala persyaratan hukum seperti komunikasi yang dibuat secara tertulis. Anda akan dianggap telah menerima pemberitahuan ketika {{env('APP_NAME')}} mengirimkannya ke alamat email Anda dan/atau melalui email akun pribadi Anda di situs {{env('APP_NAME')}}, oleh karena itu Anda harus secara teratur memeriksa email atau akun Anda di situs ini.</p>
                    <h3>17. Tempat Kedudukan Hukum Yang Berlaku</h3>
                    <p align="justify">Anda setuju bahwa terhadap persengketaan yang mungkin timbul antara Anda dengan pengguna atau antara Anda dengan {{env('APP_NAME')}} selain dengan Perjanjian ini, pada tingkat peradilan yang lebih tinggi akan diatur berdasarkan hukum yang berlaku di Negara Republik Indonesia, terlepas dari negara mana Anda berasal atau dimana Anda mengakses situs kami. Anda setuju bahwa setiap klaim atau sengketa yang mungkin Anda ajukan gugatan harus diselesaikan oleh pengadilan yang berlokasi di Jakarta-Indonesia sesuai dengan ketentuan dan peraturan BANI (Badan Arbitrase Nasional Indonesia). Anda dengan ini setuju, tunduk dan patuh pada hukum pengadilan yang berlokasi di Jakarta-Indonesia terhadap semua klaim, tuntutan atau persengketaan tersebut.</p>
                    <h3>18. Keadaan Kahar</h3>
                    <p align="justify">Keterlambatan atau kegagalan melakukan kewajiban yang harus dilakukan oleh masing masing pihak menurut PERJANJIAN ini tidak akan dianggap sebagai pelanggaran perjanjian kalau disebabkan oleh keadaan di luar kendali para pihak, seperti kebakaran, ledakan, bencana atau kecelakaan, tidak adanya atau kegagalan fasilitas pengangkutan, epidemi, taufan, angin ribut, banjir, musim kemarau atau perang baik yang dinyatakan ataupun yang tidak dinyatakan, revolusi, huru hara, tindakan musuh negara, blokade atau embargo atau karena peraturan hukum, peraturan, ordonasi, permintaan atau persyaratan dari pemerintah atau lembaga yang berwenang, pihak otoritas atau wakil dari pemerintah atau karena alasan atau sebab lain, suatu kejadian hal atau masalah apapun, sama atau tidak sama dengan yang diuraikan di muka, yang terjadi di luar kendali pihak yang terkena dan terjadinya bukan karena kesalahan atau kelalaian pihak yang terkena.</p>
                    <h3>19. Hubungi Kami</h3>
                    <p align="justify">Jika Anda memiliki informasi pelanggaran terhadap ketentuan layanan ini, atau jika Anda memiliki pertanyaan atau memerlukan bantuan kami, silahkan hubungi:</p>
                    <table width="99%" border="0" cellpadding="1" cellspacing="0">
                        <tr>
                            <td align="left" valign="top"><strong>Website</strong></td>
                            <td width="3%" align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td colspan="3" align="left" valign="top">{{env('APP_URL')}}</td>
                        </tr>
                        <tr>
                            <td width="16%" align="left" valign="top"><strong>Email</strong></td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td colspan="3" align="left" valign="top">
                                <span class="email"><a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><strong>Telepon </strong></td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td colspan="3" align="left" valign="top"><a href="tel:+6281252658218">+62 812-5265-8218</a></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><strong>Hari</strong></td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td width="40%" align="left" valign="top">Senin - Jumat</td>
                            <td width="3%" align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td width="38%" align="left" valign="top">09.00 WIB - 17.00 WIB</td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td align="left" valign="top">Sabtu</td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td align="left" valign="top">09.00 WIB - 15.00 WIB</td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td align="left" valign="top">Minggu &amp; hari libur Nasional</td>
                            <td align="left" valign="top"><div align="left"><strong>:</strong></div></td>
                            <td align="left" valign="top">Offline</td>
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
