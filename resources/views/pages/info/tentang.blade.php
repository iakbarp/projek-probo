@extends('layouts.mst')
@section('title', 'Tentang | '.env('APP_TITLE'))
@push('styles')
    <style>
        .breadcrumbs {
            background-image: url({{asset('images/slider/tentang.jpg')}});
        }

        .rating {
            border: none;
            float: left;
        }

        .rating > input {
            display: none;
        }

        .rating > label:before {
            margin: 0 5px 0 5px;
            font-size: 1.25em;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            content: "\f089";
            position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        .rating > input:checked ~ label,
        .rating:not(:checked) > label:hover,
        .rating:not(:checked) > label:hover ~ label {
            color: #ffc100;
        }

        .rating > input:checked + label:hover,
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label,
        .rating > input:checked ~ label:hover ~ label {
            color: #e1a500;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Tentang {{env('APP_NAME')}}</h2>
            <p>Anda ingin tahu lebih banyak tentang {{env('APP_NAME')}}?</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('beranda')}}"><i class="fa fa-angle-double-right"></i> Beranda</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Tentang {{env('APP_NAME')}}
                </a></li>
        </ul>
    </div>

    <!-- tentang -->
    <section class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Tentang {{env('APP_NAME')}}</h2>
                    <p class="text-align-justify">Melalui {{env('APP_NAME')}}, <strong
                            class="strong-green">Klien</strong>
                        bisa secara leluasa menawarkan tugas/proyeknya, menerima penawaran dan menentukan pilihan
                        terbaiknya. <strong class="strong-green">Pekerja</strong> bisa dengan mudah mempromosikan
                        dirinya dan melakukan penawaran. Selain itu, <strong class="strong-green">Pekerja</strong> juga
                        bisa menjual produk-produk digitalnya dan <strong class="strong-green">Klien</strong> bisa
                        membeli produk digital tersebut sesuai kebutuhan dengan kualitas terjamin.</p>
                    <ul>
                        <li><i class="far fa-check-square"></i> Tahu Harga Di Muka</li>
                        <li><i class="far fa-check-square"></i> Jaminan Pembayaran</li>
                        <li><i class="far fa-check-square"></i> Bantuan 24/7</li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <div id="about_me" class="testi-slider testi-dark text-center">
                        <img src="{{asset('images/blog/thumbs425x266/4.jpg')}}" alt="">
                        <img src="{{asset('images/blog/thumbs425x266/5.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- daftar testimoni -->
    <section class="clients-testimonials padding">
        <div class="container bot-40">
            <h2 class="text-heading border-3 text-center">Testimoni <strong class="strong-green">Pengguna</strong></h2>
            <h3 class="text-heading">Berikut adalah ulasan dari pengguna {{env('APP_NAME')}}</h3>
        </div>
        <div class="container">
            <div id="testimoni" class="testi-slider testi-dark">
                @foreach($testimoni->chunk(2) as $two)
                    <div class="education-testimonials">
                        @foreach($two as $row)
                            <div class="col-md-6 item">
                                <div class="education-content">
                                    <div class="img-info">
                                        <img src="{{$row->get_user->get_bio->foto != "" ?
                                        asset('storage/users/foto/'.$row->get_user->get_bio->foto) :
                                        asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar">
                                    </div>
                                    <div class="txt-info">
                                        <h5 style="color: #ffc100">
                                            @if($row->bintang == 1)
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 2)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 3)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 4)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            @elseif($row->bintang == 0.5)
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 1.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 2.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 3.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            @elseif($row->bintang == 4.5)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                            @endif
                                        </h5>
                                        <p>{{$row->deskripsi}}</p>
                                        <h3>{{$row->get_user->name}}</h3>
                                        <span><i class="fa fa-clock"></i> {{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- form testimoni -->
    <section class="subscribe bg-green">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="subscribe-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="title-form">
                                    <h3 class="white">{{$cek != null ? 'SUNTING/HAPUS ULASAN' : 'ULAS '.env('APP_NAME')}}</h3>
                                    @if($cek != null)
                                        <a href="{{route('hapus.testimoni',['id' => encrypt($cek->id)])}}"
                                           class="btn btn-grey delete-data">HAPUS</a>
                                    @else
                                        <p style="line-height: unset;">Beri kami ulasan dengan membagikan pengalaman
                                            Anda tentang layanan kami!</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="newsletter">
                                    <form action="{{route('kirim.testimoni')}}" class="comment-form" method="post">
                                        @csrf
                                        <input type="hidden" name="check_form"
                                               value="{{$cek != null ? $cek->id : 'create'}}">
                                        <div class="input-form" style="width: 70%">
                                            <textarea name="comment" id="comment" class="form-control"
                                                      style="resize: vertical; height: 75px; color: #fff"
                                                      placeholder="Bagikan pengalaman Anda tentang layanan kami disini&hellip;"
                                                      required>{{$cek != null ? $cek->comment : ''}}</textarea>
                                        </div>
                                        <fieldset id="rating" class="rating" aria-required="true">
                                            <label class="full" for="star5" data-toggle="tooltip"
                                                   title="Terbaik"></label>
                                            <input type="radio" id="star5" name="rating" value="5" required {{$cek != null
                                            && $cek->rate == '5' ? 'checked' : ''}}>

                                            <label class="half" for="star4half" data-toggle="tooltip"
                                                   title="Keren"></label>
                                            <input type="radio" id="star4half" name="rating" value="4.5" {{$cek != null
                                            && $cek->rate == '4.5' ? 'checked' : ''}}>

                                            <label class="full" for="star4" data-toggle="tooltip"
                                                   title="Cukup baik"></label>
                                            <input type="radio" id="star4" name="rating" value="4" {{$cek != null
                                            && $cek->rate == '4' ? 'checked' : ''}}>

                                            <label class="half" for="star3half" data-toggle="tooltip"
                                                   title="Baik"></label>
                                            <input type="radio" id="star3half" name="rating" value="3.5" {{$cek != null
                                            && $cek->rate == '3.5' ? 'checked' : ''}}>

                                            <label class="full" for="star3" data-toggle="tooltip"
                                                   title="Standar"></label>
                                            <input type="radio" id="star3" name="rating" value="3" {{$cek != null
                                            && $cek->rate == '3' ? 'checked' : ''}}>

                                            <label class="half" for="star2half" data-toggle="tooltip"
                                                   title="Cukup buruk"></label>
                                            <input type="radio" id="star2half" name="rating" value="2.5" {{$cek != null
                                            && $cek->rate == '2.5' ? 'checked' : ''}}>

                                            <label class="full" for="star2" data-toggle="tooltip" title="Buruk"></label>
                                            <input type="radio" id="star2" name="rating" value="2" {{$cek != null
                                            && $cek->rate == '2' ? 'checked' : ''}}>

                                            <label class="half" for="star1half" data-toggle="tooltip"
                                                   title="Sangat buruk"></label>
                                            <input type="radio" id="star1half" name="rating" value="1.5" {{$cek != null
                                            && $cek->rate == '1.5' ? 'checked' : ''}}>

                                            <label class="full" for="star1" data-toggle="tooltip"
                                                   title="Menyedihkan"></label>
                                            <input type="radio" id="star1" name="rating" value="1" {{$cek != null
                                            && $cek->rate == '1' ? 'checked' : ''}}>

                                            <label class="half" for="starhalf" data-toggle="tooltip"
                                                   title="Sangat menyedihkan"></label>
                                            <input type="radio" id="starhalf" name="rating" value="0.5" {{$cek != null
                                            && $cek->rate == '0.5' ? 'checked' : ''}}>
                                        </fieldset>
                                        <input type="submit" class="btn education-btn-2 color-1" value="{{$cek != null
                                        ? 'SIMPAN' : 'KIRIM'}}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#about_me, #testimoni").owlCarousel({
                navigation: false,
                slideSpeed: 600,
                autoPlay: 6000,
                singleItem: true,
                pagination: true,
                navigationText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
            });
        });

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".about-us").offset().top}, 500);
        }

        @if(session('testimoni'))
        swal('Sukses!', '{{ session('testimoni') }}', 'success');
        @endif
    </script>
@endpush
