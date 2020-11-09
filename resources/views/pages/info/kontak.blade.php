@extends('layouts.mst')
@section('title', 'Kontak | '.env('APP_TITLE'))
@push('styles')
    <style>
        .breadcrumbs {
            background-image: url({{asset('images/slider/kontak.jpg')}});
        }

        .gm-style-iw {
            width: 350px !important;
            top: 15px;
            left: 22px;
            background-color: #fff;
            box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
            border: 1px solid rgba(18, 39, 82, 0.6);
            border-radius: 2px 2px 10px 10px;
        }

        .gm-style-iw > div:first-child {
            max-width: 350px !important;
        }

        #iw-container {
            margin-bottom: 10px;
        }

        #iw-container .iw-title {
            font-family: 'Open Sans Condensed', sans-serif;
            font-size: 22px;
            font-weight: 400;
            padding: 10px;
            background-color: #122752;
            color: white;
            margin: 0;
            border-radius: 2px 2px 0 0;
        }

        #iw-container .iw-content {
            font-size: 13px;
            line-height: 18px;
            font-weight: 400;
            margin-right: 1px;
            padding: 15px 5px 20px 15px;
            max-height: 140px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .iw-content a {
            color: #122752;
            text-decoration: none;
        }

        .iw-content img {
            float: right;
            margin: 0 5px 5px 10px;
            width: 30%;
        }

        .iw-subTitle {
            font-size: 16px;
            font-weight: 700;
            padding: 5px 0;
        }

        .iw-bottom-gradient {
            position: absolute;
            width: 326px;
            height: 25px;
            bottom: 10px;
            right: 18px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
            background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
            background: -moz-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
            background: -ms-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Kontak</h2>
            <p>Jangan ragu untuk menghubungi kami!</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('beranda')}}"><i class="fa fa-angle-double-right"></i> Beranda</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Kontak</a></li>
        </ul>
    </div>

    <section class="no-padding">
        <div class="row">
            <div class="col-lg-6">
                <div id="map" style="width: 100%;height: 600px"></div>
            </div>
            <div class="col-lg-6" style="padding: 3em 5em 0px 3em;">
                <form action="{{route('kirim.kontak')}}" method="post">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="name">Nama Lengkap <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input id="kon_name" type="text" class="form-control" name="name" placeholder="Nama lengkap"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="email">Email <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input id="kon_email" type="email" class="form-control" name="email"
                                       placeholder="Alamat email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="subject">Subyek <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                                <input id="kon_subject" type="text" class="form-control" name="subject"
                                       placeholder="Subyek" minlength="3" required>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="message">Pesan <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-text-height"></i></span>
                                <textarea id="kon_message" class="form-control" name="message"
                                          placeholder="Tulis pesan Anda disini&hellip;" rows="5"
                                          style="resize: vertical" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-dark-red btn-block"
                                    style="padding-top: 8px;padding-bottom: 8px"><b>KIRIM</b></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng(-7.5560706, 112.4726686);

            var mapOptions = {
                zoom: 15,
                center: myLatlng,
            };

            var mapElement = document.getElementById('map');

            var map = new google.maps.Map(mapElement, mapOptions);

            var contentString =
                '<div id="iw-container">' +
                '<div class="iw-title">BAGASKU (Bantu Tugasku)</div>' +
                '<div class="iw-content">' +
                '<img class="img-fluid" src="{{asset('images/logo/icon.png')}}">' +
                '<div class="iw-subTitle">Kontak</div>' +
                '<p>Pohkecik, Dlanggu, Mojokerto, Jawa Timur — 61371.<br>' +
                '<br>Telepon: <a href="tel:+6281252658218">+62 812-5265-8218</a>' +
                '<br>Email: <a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a>' +
                '</p></div><div class="iw-bottom-gradient"></div></div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 350
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: '{{asset('images/pin.png')}}',
                anchorPoint: new google.maps.Point(0, -29)
            });

            infowindow.open(map, marker);

            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });

            google.maps.event.addListener(infowindow, 'domready', function () {
                var iwOuter = $('.gm-style-iw');
                var iwBackground = iwOuter.prev();

                iwBackground.children(':nth-child(2)').css({'display': 'none'});
                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                iwOuter.css({left: '5px', top: '1px'});
                iwOuter.parent().parent().css({left: '0'});

                iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').find('div').children().css({
                    'box-shadow': 'rgba(72, 181, 233, 0.6) 0 1px 6px',
                    'z-index': '1'
                });

                var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({
                    background: '#fff',
                    opacity: '1',
                    width: '30px',
                    height: '30px',
                    right: '15px',
                    top: '6px',
                    border: '6px solid #48b5e9',
                    'border-radius': '50%',
                    'box-shadow': '0 0 5px #3990B9'
                });

                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', init);

        function goToAnchor() {
            $('html,body').animate({scrollTop: $("#map").offset().top}, 500);
        }

        @if(session('kontak'))
        swal('Berhasil mengirimkan pesan!', '{{ session('kontak') }}', 'success');
        @endif
    </script>
@endpush
