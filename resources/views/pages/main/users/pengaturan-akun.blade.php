@extends('layouts.mst')
@section('title', 'Pengaturan Akun: '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        .has-feedback .form-control-feedback {
            width: 36px;
            height: 36px;
            line-height: 36px;
        }

        .image-upload > input {
            display: none;
        }

        .image-upload label {
            cursor: pointer;
            width: 100%;
        }
    </style>
@endpush
@section('content')
    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                    <div class="card">
                        <form class="form-horizontal" role="form" method="POST" id="form-ava"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('put') }}
                            <div class="img-card image-upload">
                                <label for="file-input">
                                    <img style="width: 100%" class="show_ava" alt="Avatar" src="{{$user->get_bio->foto
                                    == "" ? asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg') :
                                    asset('storage/users/foto/'.$user->get_bio->foto)}}" data-placement="bottom"
                                         data-toggle="tooltip" title="Klik disini untuk mengubah foto Anda!">
                                </label>
                                <input id="file-input" name="foto" type="file" accept="image/*">
                                <div id="progress-upload">
                                    <div class="progress-bar progress-bar-info progress-bar-striped active"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100" style="background-color: #122752;z-index: 20">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-content">
                            <div class="card-title text-center">
                                <a href="{{route('user.profil')}}">
                                    <h4 class="aj_name" style="color: #122752">{{$user->name}}</h4></a>
                                <small style="text-transform: none">
                                    <a class="show_username" href="{{route('profil.user',
                                    ['username' => $user->username])}}">{{$user->username}}</a>
                                </small>
                            </div>
                            <div class="card-title">
                                <form class="form-horizontal" role="form" method="POST" id="form-username">
                                    @csrf
                                    {{ method_field('put') }}
                                    <div id="show_username_settings" class="row"
                                         style="color: #122752;cursor: pointer;font-size: 14px">
                                        <div class="col-md-12 text-right">
                                            <i class="fa fa-edit mr-2"></i>UBAH USERNAME
                                        </div>
                                    </div>
                                    <div id="username_settings" style="display: none">
                                        <div id="error_username" class="row form-group has-feedback"
                                             style="margin-bottom: 0">
                                            <div class="col-md-12">
                                                <input id="username" type="text" class="form-control" name="username"
                                                       placeholder="Username" value="{{$user->username}}" minlength="4"
                                                       required>
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                <span class="help-block">
                                                    <strong class="strong-error" id="aj_username"
                                                            style="text-transform: none"></strong>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <button id="btn_save_username" class="btn btn-link btn-sm btn-block"
                                                        type="submit" style="border: 1px solid #ccc">
                                                    <i class="fa fa-user-lock mr-2"></i>SIMPAN PERUBAHAN
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <a href="{{route('profil.user', ['username' => $user->username])}}"
                                   id="btn_mode_publik" class="btn btn-link btn-sm btn-block"
                                   style="border: 1px solid #ccc">Lihat Mode Publik</a>
                                <hr style="margin: 10px 0">
                                <table class="stats" style="font-size: 14px; margin-top: 0">
                                    <tr>
                                        <td><i class="fa fa-calendar-check"></i></td>
                                        <td>&nbsp;Bergabung Sejak</td>
                                        <td>
                                            : {{$user->created_at->formatLocalized('%d %B %Y')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-clock"></i></td>
                                        <td>&nbsp;Update Terakhir</td>
                                        <td style="text-transform: none;">
                                            : {{$user->updated_at->diffForHumans()}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="card">
                        <form class="form-horizontal" role="form" method="POST" id="form-password">
                            @csrf
                            {{ method_field('put') }}
                            <div class="card-content">
                                <div class="card-title">
                                    <small style="font-weight: 600">Pengaturan Akun</small>
                                    <hr class="mt-0">
                                    <small>E-mail Utama (terverifikasi)</small>
                                    <div class="row form-group has-feedback">
                                        <div class="col-md-12">
                                            <input type="email" class="form-control" value="{{$user->email}}" disabled>
                                            <span class="glyphicon glyphicon-check form-control-feedback"></span>
                                        </div>
                                    </div>

                                    <small style="cursor: pointer; color: #122752" id="show_password_settings">Ubah Kata
                                        Sandi ?
                                    </small>
                                    <div id="password_settings" style="display: none">
                                        <div id="error_curr_pass" class="row form-group has-feedback">
                                            <div class="col-md-12">
                                                <input placeholder="Kata sandi lama" id="check_password" type="password"
                                                       class="form-control" name="password" minlength="6" required
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
                                                <input placeholder="Kata sandi baru" id="password" type="password"
                                                       class="form-control" name="new_password" minlength="6" required>
                                                <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                      style="pointer-events: all;cursor: pointer"></span>
                                                @if ($errors->has('new_password'))
                                                    <span class="help-block">
                                                <strong
                                                    class="strong-error">{{ $errors->first('new_password') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <input placeholder="Ulangi kata sandi baru" id="password-confirm"
                                                       type="password"
                                                       class="form-control" name="password_confirmation" minlength="6"
                                                       required
                                                       onkeyup="return checkPassword()">
                                                <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                      style="pointer-events: all;cursor: pointer"></span>
                                                <span class="help-block">
                                            <strong class="strong-error aj_new_pass"
                                                    style="text-transform: none"></strong>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-read-more">
                                <button id="btn_save_password" class="btn btn-link btn-block" disabled>
                                    <i class="fa fa-lock mr-2"></i>SIMPAN PERUBAHAN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $("#show_username_settings").on('click', function () {
            $("#username_settings").toggle(300);
            $("#btn_mode_publik").toggle(300);
        });

        $("#form-username").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('user.update.pengaturan')}}',
                data: new FormData($("#form-username")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal('Pengaturan Akun', 'Username tersebut telah digunakan!', 'error');
                        $("#error_username").addClass('has-error');
                        $(".aj_username").text("Username tersebut telah digunakan!").parent().show();

                    } else {
                        swal('Pengaturan Akun', 'Username Anda berhasil diperbarui!', 'success');
                        $("#error_username").removeClass('has-error');
                        $(".aj_username").text("").parent().hide();
                        $("#show_username_settings").click();
                        $(".show_username").text(data);
                    }
                },
                error: function () {
                    swal('Oops...', 'Terjadi suatu kesalahan! Silahkan segarkan browser Anda.', 'error');
                }
            });
            return false;
        });

        $("#show_password_settings").on('click', function () {
            $(this).text(function (i, v) {
                return v === "PENGATURAN KATA SANDI" ? "Ubah Kata Sandi ?" : "PENGATURAN KATA SANDI";
            });
            if ($(this).text() === 'Ubah Kata Sandi ?') {
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

        document.getElementById("file-input").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload .progress-bar");

            if (!window.File && window.FileReader && window.FileList && window.Blob) {
                swal('PERHATIAN!', "Browser yang Anda gunakan tidak support! Silahkan perbarui atau gunakan browser yang lainnya.", 'warning');

            } else {
                if (files_size > max_file_size) {
                    swal('ERROR!', "Ukuran total " + file_name + " adalah " + humanFileSize(files_size) +
                        ", ukuran file yang diperbolehkan adalah " + humanFileSize(max_file_size) +
                        ", coba unggah file yang ukurannya lebih kecil!", 'error');

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal('ERROR!', "Tipe file " + file_name + " tidak support!", 'error');

                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('user.update.pengaturan')}}',
                                    data: new FormData($("#form-ava")[0]),
                                    contentType: false,
                                    processData: false,
                                    mimeType: "multipart/form-data",
                                    xhr: function () {
                                        var xhr = $.ajaxSettings.xhr();
                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (event) {
                                                var percent = 0;
                                                var position = event.loaded || event.position;
                                                var total = event.total;
                                                if (event.lengthComputable) {
                                                    percent = Math.ceil(position / total * 100);
                                                }
                                                //update progressbar
                                                $("#progress-upload").css("display", "block");
                                                progress_bar_id.css("width", +percent + "%");
                                                progress_bar_id.text(percent + "%");
                                                if (percent == 100) {
                                                    progress_bar_id.removeClass("progress-bar-info");
                                                    progress_bar_id.addClass("progress-bar");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar");
                                                    progress_bar_id.addClass("progress-bar-info");
                                                }
                                            }, true);
                                        }
                                        return xhr;
                                    },
                                    success: function (data) {
                                        $(".show_ava").attr('src', data);
                                        swal('SUKSES!', 'Foto Anda berhasil diperbarui!', 'success');
                                        $("#progress-upload").css("display", "none");
                                    },
                                    error: function () {
                                        swal('Oops...', 'Terjadi suatu kesalahan!  Silahkan segarkan browser Anda.', 'error');
                                    }
                                });
                                return false;
                            }
                        } else {
                            swal('Oops...', 'Tidak ada file yang dipilih!', 'error');
                        }
                    });
                }
            }
        };

        function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        }
    </script>
@endpush
