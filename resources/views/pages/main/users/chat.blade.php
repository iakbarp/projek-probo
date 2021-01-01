@extends('layouts.mst')
@section('title', 'Message | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.min.css')}}">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .inbox_people {
            background: #fff;
            float: left;
            overflow: hidden;
            width: 30%;
            border-right: 1px solid #ddd;
            margin-right: .5em;
            border-radius: 10px;
        }

        .inbox_msg {
            border: 1px solid #ddd;
            clear: both;
            overflow: hidden;
            border-radius: 6px;

        }

        .top_spac {
            margin: 20px 0 0;
        }

        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 100%;
            padding: 0;
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
            border-radius: 4px;
            background-color: #2677ff;
        }

        .recent_heading h4 {
            color: #0465ac;
            font-size: 16px;
            margin: auto;
            line-height: 29px;
        }

        .srch_bar input {
            outline: none;
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 100%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 12px;
            color: #989898;
            margin: auto;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_img img {
            width: 100%
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #ddd;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #e8f6ff;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .incoming_msg_img img {
            width: 100%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #2677ff none repeat scroll 0 0;
            border-radius: 0 15px 15px 15px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 69%;
        }

        .sent_msg p {
            background: #0465ac;
            border-radius: 12px 15px 15px 0;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
            outline: none;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #2677ff none repeat scroll 0 0;
            border: none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 15px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .upload_file_btn {
            background: white none repeat scroll 0 0;
            border: none;
            border-radius: 50%;
            color: black;
            cursor: pointer;
            font-size: 15px;
            height: 33px;

            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4 style="color: white"><i class="far fa-comments"></i>&nbsp;CHAT </h4>
                        </div>
                    </div>
                    <div class="inbox_chat scroll" id="chat_list">
                        <div style="align-content: center;display: none" id="loading_chat_list">
                            <img src="{{asset('images/loading.gif')}}" alt="">
                        </div>
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input type="text" class="search-bar"  placeholder="Search" onkeyup="search_user(this.value)">
                        </div>
                    </div>
                </div>
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4 style="color: white" id="chat_target"><i class="far fa-comments"></i>&nbsp;</h4>
                    </div>
                </div>
                <div class="mesgs">
                    <div style="align-content: center;display: none" id="loading_chat">
                        <img src="{{asset('images/loading.gif')}}" alt="">
                    </div>
                    <div class="msg_history" id="msg_history">

                    </div>
                    <div class="type_msg" style="display: none">
                        <div class="input_msg_write">
                            <input type="hidden"  name="chat_id" id="chat_id" >
                            <input type="text" class="write_msg" placeholder="Type a message" id="chat_message"/>
{{--                            <button class="upload_file_btn"><input type="file"></button>--}}
                            <button class="msg_send_btn" type="button" onclick="send_message()"><i class="fa fa-paper-plane"
                                                                          aria-hidden="true"></i></button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var _token = '{{auth('api')->tokenById(Auth::id())}}';
        $(document).ready(function () {
            // $.get("message/", function(data, status){
            //     alert("Data: " + data + "\nStatus: " + status);
            // });
            $('#msg_history');
            $.ajax({
                url: "/api/message/",
                type: "GET",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'bearer ' + _token);
                },
                success: function (data) {
                    var user_data = data.data.user;
                    $.each(user_data, function (i, item) {
                        $('#chat_list').append(
                            '<div class="chat_list" >\n' +
                            '                            <div class="chat_people img-card image-upload menu-item-has-children avatar" onclick="load_msg(' + item.id + ',\'' + item.name + '\')">\n' +
                            '                                <div class="chat_img"><img class="img-thumbnail" style="width: 100%"\n' +
                            '                                                           src="' + item.foto + '"' +
                            '                                                           alt="avatar"></div>\n' +
                            '                                <div class="chat_ib">\n' +
                            '                                    <h5>' + item.name + '</h5>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>')
                    });
                }
            });
        });

        function load_msg(chat_id, target) {
            $('#chat_target').text(target);
            $.ajax({
                url: "/api/message?chat_id=" + chat_id,
                type: "GET",
                beforeSend: function (xhr) {
                    $('#loading_chat').show();
                    $('#msg_history').empty();

                    xhr.setRequestHeader('Authorization', 'bearer ' + _token);

                },
                success: function (data) {
                    var chat_data = data.data.chat;
                    $('#loading_chat').hide();
                    $('#chat_id').val(chat_id);
                    $('.type_msg').show();
                    $.each(chat_data, function (i, item) {
                        if (item.is_me == 0) {
                            $('#msg_history').prepend(' <div class="incoming_msg img-card image-upload menu-item-has-children avatar">\n' +
                                '                            <div class="incoming_msg_img"><img\n' +
                                '                                   src="' + item.foto + '" alt="avatar"></div>\n' +
                                '                            <div class="received_msg">\n' +
                                '                                <div class="received_withd_msg">\n' +
                                '                                    <p style="color: white">' + item.message + '</p>\n' +
                                '                                    <span class="time_date">'+item.created_at+'</span></div>\n' +
                                '                            </div>\n' +
                                '                        </div>\n'
                            )
                        } else {
                            $('#msg_history').prepend(
                                '                        <div class="outgoing_msg">\n' +
                                '                            <div class="sent_msg">\n' +
                                '                                <p>' + item.message + '</p>\n' +
                                '                                <span class="time_date"> '+item.created_at+'</span>\n' +
                                '                            </div>\n' +
                                '                        </div>'
                            )
                        }

                    });
                }
            });
        }

        function send_message() {
            if($('#chat_message').val().length === 0){
                swal('Perhatian', 'isikan pesan terlebih dahulu', 'warning');
            }else{

                $.ajax({
                    url: "/api/message/send" ,
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        chat_id :$('#chat_id').val(),
                        message:  $('#chat_message').val()
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'bearer ' + _token);
                    },
                    success: function (data) {

                        $('#msg_history').append(
                            '                        <div class="outgoing_msg">\n' +
                            '                            <div class="sent_msg">\n' +
                            '                                <p>'+$('#chat_message').val()+'</p>\n' +
                            '                                <span class="time_date"> sekarang </span>\n' +
                            '                            </div>\n' +
                            '                        </div>'
                        )
                        $('#chat_message').val('');
                    },
                    error: function (data) {
                        swal('Perhatian', 'Terjadi error', 'error');
                    }
                });


            }
        }

        function search_user(user) {
            $.ajax({
                url: "/api/message?q="+user,
                type: "GET",
                beforeSend: function (xhr) {
                    $('#loading_chat_list').show();

                    xhr.setRequestHeader('Authorization', 'bearer ' + _token);
                },
                success: function (data) {
                    $('#chat_list').empty();
                    $('#loading_chat_list').hide();
                    var user_data = data.data.user;
                    $.each(user_data, function (i, item) {
                        $('#chat_list').prepend(
                            '<div class="chat_list" >\n' +
                            '                            <div class="chat_people img-card image-upload menu-item-has-children avatar" onclick="load_msg(' + item.id + ',\'' + item.name + '\')">\n' +
                            '                                <div class="chat_img"><img class="img-thumbnail" style="width: 100%"\n' +
                            '                                                           src="' + item.foto + '"' +
                            '                                                           alt="avatar"></div>\n' +
                            '                                <div class="chat_ib">\n' +
                            '                                    <h5>' + item.name + '</h5>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>')
                    });
                }
            });
        }
    </script>

@endpush
