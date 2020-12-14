@extends('layouts.mst')
@section('title', 'Profil: '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-tabs-responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/grid-list.css')}}">
    <link rel="stylesheet" href="{{asset('css/list-accordion.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        [data-scrollbar] {
            max-height: 350px;
        }

        .content-area {
            position: relative;
            cursor: pointer;
            overflow: hidden;
            margin: 1em auto;
        }

        .custom-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: all 400ms ease-in-out;
            height: 100%;
        }

        .custom-overlay:hover {
            opacity: 1;
        }

        .custom-text {
            position: absolute;
            top: 50%;
            left: 10px;
            right: 10px;
            transform: translateY(-50%);
            color: #eee;
        }

        .content-area img {
            transition: transform .5s ease;
        }

        .content-area:hover img {
            transform: scale(1.2);
        }

        .lg-backdrop {
            z-index: 9999999;
        }

        .lg-outer {
            z-index: 10000000;
        }

        .lg-sub-html h4 {
            color: #eee;
        }

        .lg-sub-html p {
            color: #bbb;
        }

        .note-editor.note-airframe .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-editable,
        .note-editor.note-airframe .note-placeholder, .note-editor.note-frame .note-placeholder {
            padding: 20px 30px;
            text-transform: none;
        }
    </style>
@endpush
@section('content')

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                    <!-- personal -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <br>
                                <div class="img-card avatar">
                                    <img class="img-thumbnail" style="width: 35%" alt="Avatar" src="{{$user->get_bio->foto== "" ?
                                    asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                    asset('storage/users/foto/'.$user->get_bio->foto)}}">
                                </div>

                                <div class="card-content">
                                    <div class="card-title text-center">
                                        <a href="{{$user->id == Auth::id() ? route('user.profil') : url()->current()}}">
                                            <h4 class="aj_name" style="color: #122752">{{$user->name}}</h4></a>
                                        {{--                                        <small style="text-transform: none">{{$user->get_bio->status--}}
                                        {{--                                        != "" ? $user->get_bio->status : 'Status (-)'}}</small>--}}
                                    </div>
                                    <div class="card-title">
                                        <table style="font-size: 14px;">
                                            <tr>
                                                <td><i class="fa fa-map-marker-alt"></i></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    @if($user->get_bio->kota_id != "" && $user->get_bio->kewarganegaraan != "")
                                                        {{$user->get_bio->get_kota->nama.', '.$user->get_bio->get_kota->get_provinsi->nama.', '.$user->get_bio->kewarganegaraan}}
                                                    @else
                                                        Kabupaten/Kota, Provinsi (-)
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-tools"></i></td>
                                                <td>&nbsp;</td>
                                                <td>{{$user->get_service->count()}} layanan</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-thumbs-up"></i></td>
                                                <td>&nbsp;</td>
                                                <td style="text-transform: none">
                                                    <span style="color: #ffc100">
                                                        @if(round($rating_pekerja * 2) / 2 == 1)
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 2)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 3)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 4)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 0.5)
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 1.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 2.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 3.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                            <i class="far fa-star"></i>
                                                        @elseif(round($rating_pekerja * 2) / 2 == 4.5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @endif </span>
                                                    <b>{{round($rating_pekerja * 2) / 2}}</b>
                                                    ({{count($ulasan_pekerja)}}
                                                    ulasan)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i></td>
                                                <td>&nbsp;</td>
                                                <td>Bergabung Sejak : {{$user->created_at->formatLocalized('%d %B %Y')}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-clock"></i></td>
                                                <td>&nbsp;</td>
                                                <td>Update Terakhir : {{$user->updated_at->diffForHumans()}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <button id="btn_pin" class="btn" type="button"--}}
{{--                            style="padding: 10px 40px;border-radius: 5px;border: 1px solid black;width: 100%"--}}
{{--                            title="Topup">--}}

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal" role="form" method="POST" id="form-password">
                                    @csrf
                                    {{ method_field('put') }}
                                    <div class="card-content">
                                        <div class="card-title">
                                            <i style="color: black;" class="fa fa-key mr-2"></i><b>&nbsp;PENGATURAN PIN</b></button>
                                            {{--                                            <hr class="mt-0">--}}
                                            {{--                                            <small>E-mail Utama (terverifikasi)</small>--}}
                                            <div class="row form-group has-feedback">
                                                <div class="col-md-12">
                                                    <input type="hidden" class="form-control" value="{{$user->email}}" disabled>
                                                    <span class="glyphicon glyphicon-check form-control-feedback"></span>
                                                </div>
                                            </div>

                                            <small style="cursor: pointer; color: #122752" id="show_password_settings">Ubah Pin
                                            </small>
                                            <div id="password_settings" style="display: none">
                                                <div id="error_curr_pass" class="row form-group has-feedback">
                                                    <div class="col-md-12">
                                                        <input placeholder="Konfirmasi Password" id="check_password" type="password"
                                                               class="form-control" name="password" minlength="6" maxlength="6" required
                                                               autofocus>
                                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                              style="pointer-events: all;cursor: pointer"></span>
                                                        <span class="help-block">
                                            <strong class="strong-error aj_pass" style="text-transform: none"></strong>
                                        </span>
                                                    </div>
                                                </div>

                                                <div id="error_new_pass" class="row form-group has-feedback">
                                                    <div class="col-md-12">
                                                        <input placeholder="Pin baru" id="password" type="password"
                                                               class="form-control" name="new_password" minlength="6" maxlength="6" onkeypress="return numberOnly(event, false)" required>
                                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                              style="pointer-events: all;cursor: pointer"></span>
                                                        @if ($errors->has('new_password'))
                                                            <span class="help-block">
                                                <strong
                                                    class="strong-error">{{ $errors->first('new_password') }}</strong>
                                            </span>
                                                        @endif
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <input placeholder="Ulangi Pin baru" id="password-confirm"
                                                               type="password"
                                                               class="form-control" name="password_confirmation" minlength="6" maxlength="6" onkeypress="return numberOnly(event, false)"
                                                               required
                                                               onkeyup="return checkPassword()">
                                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                              style="pointer-events: all;cursor: pointer"></span>
                                                        <span class="help-block">
                                            <strong class="strong-error aj_new_pass"
                                                    style="text-transform: none"></strong>
                                        </span>
                                                    </div>

                                                    <div class="col-md-12" id="btn_save_password">
                                                        <button class="pull-right"
                                                                style="border: 1px solid #ccc;color: #333;background: #247bff;
    text-transform: uppercase;
    font-size: 12px;
    display: inline-block;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    border-radius: 7px;
    font-weight: 500;
    padding: 10px 18px;
    -webkit-transition-property: color;
    transition-property: color;
    -webkit-transition-duration: 0.1s;
    transition-duration: 0.1s;
    text-align: center;"><small style="color: white">UBAH</small>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <!-- Topup -->
                    <div class="row card-data">
                        <div class="col-lg-12">
                            <div class="card" style="background-color: #2979FF;color: white">
                                <div class="card-content">
                                    <div class="card-title">
                                        <b class="fa fa-wallet" style="font-size: 30px"></b>&nbsp;<small style="font-size: 30px">UNDAGI PAY</small>
                                        <hr class="mt-0">
                                        <table>
                                            <tr>
                                            <td>
                                                <b data-scrollbar style="text-transform: none; font-size: 40px;margin-right: 5em">SALDO ANDA :</b>
                                            </td>
                                            <td>
                                                <b data-scrollbar style="text-transform: none; font-size: 35px">Rp. 1.500.000</b>
                                            </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="margin-right: 5em">
                                    <button id="" class="btn" type="button"
                                            style="padding: 10px 40px;border-radius: 5px"
                                            title="Topup">
                                        <i style="color:#2979FF;" class="fa fa-plus-circle mr-2"></i><b style="color: #2979FF">&nbsp;TOPUP</b></button>
                                    <button id="btn_withdraw" class="btn" type="button"
                                            data-toggle="tooltip" style="padding: 10px 40px;border-radius: 5px"
                                            title="Withdraw">
                                        <i style="color:#2979FF;" class="fa fa-wallet mr-2"></i><b style="color: #2979FF">&nbsp;Withdraw</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row card-data">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <small>Transaksi</small>
                                        <hr class="mt-0">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div data-scrollbar style="background-color: #2979FF;border: black 1px;height: 116px;width: 119px;margin-right: 1em">
                                                        <b class="fa fa-wallet" style="font-size: 62px;color: white;display: block;margin-right: auto;margin-left: auto;text-align: center;padding: 30px"></b>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b data-scrollbar style="text-transform: none; font-size: 20px">Pembayaran melalui undagipay berhasil</b>
                                                    <small style="font-size: 10px">Pembayaran untuk transaksi blablabla menggunakan Undagi Pay telah berhasil dan
                                                        dana sebesar Rp. 5,000,000 telah ditambahkan di Undagi Pay-mu</small>
                                                    <br>
                                                    <small style="font-size: 10px">Timestamp</small>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="konfirmasi_pin">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{asset('images/logo/undagi_logo.png')}}" width="120">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="Konfirmasi Pin" class="col-sm-4 col-form-label">Konfirmasi Pin</label>
                                <div class="col-sm-8">
                                    <b>KONFIRMASI PIN</b>
                                    <input type="password" class="form-control" id="pin" name="Pin" minlength="6" maxlength="6" onkeypress="return numberOnly(event, false)">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn2" id="submit_withdraw"><span style="color: white">Konfirmasi</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal_withdraw">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{asset('images/logo/undagi_logo.png')}}" width="120">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="JumlahWithdraw" class="col-sm-4 col-form-label">Jumlah Withdraw</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="withdraw" placeholder="Rp. " name="withdraw" onkeypress="return numberOnly(event, false)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="NamaBank" class="col-sm-4 col-form-label">Bank Tujuan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="bank" name="bank" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Nomor Rekening" class="col-sm-4 col-form-label">Nomor Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="rekening" name="rekening" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Atas Nama" class="col-sm-4 col-form-label">Atas Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="an" name="an" disabled>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn2" id="submit_withdraw"><span style="color: white">Withdraw</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/masonry/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <script>

        $("#modal_topup").on('click', function () {
            $("#modal_topup").modal("show");
        });
        var $btn_withdraw = $("#btn_withdraw");
        var $submitWithdraw = $("#submit_withdraw");
        $btn_withdraw.on('click', function () {
            $("#konfirmasi_pin").modal("show");
        });

        $submitWithdraw.on('click', function () {
            $("#modal_withdraw").modal("show");
        });

        $("#show_password_settings").on('click', function () {
            $(this).text(function (i, v) {
                return v === "UBAH PIN" ? "Ubah Pin ?" : "UBAH PIN";
            });
            if ($(this).text() === 'Ubah Pin ?') {
                this.style.color = "#122752";
            } else {
                this.style.color = "#7f7f7f";
            }

            $("#password_settings").toggle(300);
            if ($("#btn_save_password").attr('disabled')) {
                $("#btn_save_password").removeAttr('disabled');
            } else {
                $("#btn_save_password").attr('disabled', 'disabled');
            }
        });

        $('#check_password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#check_password').togglePassword();
        });

        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password').togglePassword();
        });

        $('#password-confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password-confirm').togglePassword();
        });

        function checkPassword() {
            var new_pas = $("#password").val(),
                re_pas = $("#password-confirm").val();
            if (new_pas != re_pas) {
                $("#error_new_pass").addClass('has-error');
                $(".aj_new_pass").text("Konfirmasi password harus sama dengan password baru Anda!").parent().show();
                $("#btn_save_password").attr('disabled', 'disabled');
            } else {
                $("#error_new_pass").removeClass('has-error');
                $(".aj_new_pass").text("").parent().hide();
                $("#btn_save_password").removeAttr('disabled');
            }
        }
        $("#form-password").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('user.update.pengaturan')}}',
                data: new FormData($("#form-password")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal('Pengaturan Akun', 'Kata sandi lama Anda salah!', 'error');
                        $("#error_curr_pass").addClass('has-error');
                        $("#error_new_pass").removeClass('has-error');
                        $(".aj_pass").text("Password lama Anda salah!").parent().show();
                        $(".aj_new_pass").text("").parent().hide();

                    } else if (data == 1) {
                        swal('Pengaturan Akun', 'Konfirmasi kata sandi Anda tidak cocok!', 'error');
                        $("#error_curr_pass").removeClass('has-error');
                        $("#error_new_pass").addClass('has-error');
                        $(".aj_pass").text("").parent().hide();
                        $(".aj_new_pass").text("Konfirmasi kata sandi Anda tidak cocok!").parent().show();

                    } else {
                        swal('Pengaturan Akun', 'Kata sandi Anda berhasil diperbarui!', 'success');
                        $("#form-password").trigger("reset");
                        $("#error_curr_pass").removeClass('has-error');
                        $("#error_new_pass").removeClass('has-error');
                        $(".aj_pass").text("").parent().hide();
                        $(".aj_new_pass").text("").parent().hide();
                        $("#show_password_settings").click();
                    }
                },
                error: function () {
                    swal('Oops...', 'Terjadi suatu kesalahan! Silahkan segarkan browser Anda.', 'error');
                }
            });
            return false;
        });
    </script>
@endpush