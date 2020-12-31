<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form  method="POST" id="form-topup">
                            @csrf
                            {{method_field('put')}}
                            <input type="hidden" name="id">
                            <input type="hidden" name="user_id" value="{{$id}}">
                            <input type="hidden" name="cek" value="topup">
                            <input type="hidden" value="{{$jumlah}}"
                                           name="jumlah" >
                                           <input type="submit">
                            

                        </form>

</body>
<script src="{{asset('js/jquery.min.js')}}"></script>

<script src="{{asset('vendor/masonry/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{env('MIDTRANS_SERVER_KEY')}}"></script>
    <script>


        $("#form-topup").on('submit', function (e) {
            e.preventDefault();
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: '{{route('get.midtrans.snap')}}',
                    type: "GET",
                    data: $("#form-topup").serialize(),
                    beforeSend: function () {
                        $("#form-topup button[type=submit]").prop("disabled", true)
                            .html('LOADING&hellip; <span class="spinner-border spinner-border-sm float-right" role="status" aria-hidden="true"></span>');
                    },
                    complete: function () {
                        $("#form-topup button[type=submit]").prop("disabled", false)
                            .html('BAYAR SEKARANG <i class="fa fa-chevron-right float-right"></i>');
                    },
                    success: function (val) {
                        if (val.error == true) {
                            swal('PERHATIAN!', val.message, 'warning');
                        } else {
                            snap.pay(val.data, {
                                language: '{{app()->getLocale()}}',
                                onSuccess: function (result) {
                                    responseMidtrans('finish', result);
                                },
                                onPending: function (result) {
                                    responseMidtrans('unfinish', result);
                                },
                                onError: function (result) {
                                    swal('Oops..', result.status_message, 'error');
                                }
                            });
                        }
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);
        });

        function responseMidtrans(url, result) {
            if (result.payment_type == 'credit_card' || result.payment_type == 'bank_transfer' || result.payment_type == 'echannel') {
                swal({
                    title: 'Loading...',
                    text: 'Mohon tunggu, transaksi Anda sedang diproses',
                    icon: 'warning',
                    buttons: false,
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                    timer: 2000
                });
                setTimeout(function () {
                    swal({
                        title: "SUKSES!",
                        text: 'Transaksi berhasil! Semoga Anda dan keluarga sehat selalu :) #dirumahaja',
                        icon: 'success',
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                        timer: 3000
                    });
                    setTimeout(function () {
                        location.href = '{{url()->current()}}'
                    }, 3000);
                }, 2000);
            } else {
                swal('Oops..', 'Maaf kanal pembayaran yang Anda pilih masih maintenance, silahkan pilih kanal lainnya.', 'error');
            }
        }

        $("#form-topup").submit();
    </script>

</html>
