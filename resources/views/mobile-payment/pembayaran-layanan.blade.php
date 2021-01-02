<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="{{asset('vendor/sweetalert/sweetalert2.css')}}">

</head>
<body>
<form  method="POST" id="form-topup">
                            @csrf
                            {{method_field('put')}}
                            <input type="hidden" name="id" value={{$pengerjaan_layanan_id}}>
                            <input type="hidden" name="user_id" value="{{$id}}">
                            <input type="hidden" name="cek" value="service">
                            <input type="hidden" value="{{$jumlah_pembayaran}}"
                                           name="jumlah_pembayaran" >
                                           <input type="hidden" name="dp" value="{{$dp}}">
                            
                                           
                            

                        </form>



</body>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>

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
                                    location.href = '{{url("?status=")}}'+result.status_message;
                                    
                                },
                                 onClose: function (result) {
                                    location.href = '{{url("?status=gagal")}}';
                                }
                            });
                        }
                    },
                    error: function () {
                         location.href = '{{url("?status=")}}'+'Terjadi kesalahan! Silahkan, segarkan browser Anda.';
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
                   location.href = '{{url("?status=")}}'+'berhasil';
                }, 2000);
            } else {
                location.href = '{{url("?status=")}}'+'Maaf kanal pembayaran yang Anda pilih masih maintenance, silahkan pilih kanal lainnya.';
                
            }
        }

        $("#form-topup").submit();
    </script>

</html>
