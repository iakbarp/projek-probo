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
            padding:0;
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

        .mesgs{
            float: left;
            padding: 30px 15px 0 25px;
            width:69%;
        }

        .sent_msg p {
            background:#0465ac;
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
            outline:none;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #2677ff none repeat scroll 0 0;
            border:none;
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
            border:none;
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
                         <h4 style="color: white"><i class="far fa-comments"></i>&nbsp;CHAT</h4>
                    </div>
                </div>
                <div class="inbox_chat scroll">
                    <div class="chat_list">
                        <div class="chat_people img-card image-upload menu-item-has-children avatar">
                            <div class="chat_img"> <img class="img-thumbnail" style="width: 100%" src="{{asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar"> </div>
                            <div class="chat_ib">
                                <h5>Nilasanti Puspita</h5>
                            </div>
                        </div>
                    </div>
                    <div class="chat_list">
                        <div class="chat_people img-card image-upload menu-item-has-children avatar">
                            <div class="chat_img"> <img class="img-thumbnail" style="width: 100%" src="{{asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar"> </div>
                            <div class="chat_ib">
                                <h5>Nilasanti Puspita</h5>
                            </div>
                        </div>
                    </div>
                    <div class="chat_list">
                        <div class="chat_people img-card image-upload menu-item-has-children avatar">
                            <div class="chat_img"> <img class="img-thumbnail" style="width: 100%" src="{{asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar"> </div>
                            <div class="chat_ib">
                                <h5>Nilasanti Puspita</h5>
                            </div>
                        </div>
                    </div>
                    <div class="chat_list">
                        <div class="chat_people img-card image-upload menu-item-has-children avatar">
                            <div class="chat_img"> <img class="img-thumbnail" style="width: 100%" src="{{asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar"> </div>
                            <div class="chat_ib">
                                <h5>Nilasanti Puspita</h5>
                            </div>
                        </div>
                    </div>
                    <div class="chat_list">
                        <div class="chat_people img-card image-upload menu-item-has-children avatar">
                            <div class="chat_img"> <img class="img-thumbnail" style="width: 100%" src="{{asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar"> </div>
                            <div class="chat_ib">
                                <h5>Nilasanti Puspita</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" class="search-bar"  placeholder="Search">
                    </div>
                </div>
            </div>
            <div class="headind_srch">
                <div class="recent_heading">
                    <h4 style="color: white"><i class="far fa-comments"></i>&nbsp;Nilasanti Puspita</h4>
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history">
                    <div class="incoming_msg img-card image-upload menu-item-has-children avatar">
                        <div class="incoming_msg_img"> <img src="{{asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}" alt="avatar"> </div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p style="color: white">Test which is a new approach to have all
                                    solutions</p>
                                <span class="time_date"> 11:01 AM    |    June 9</span></div>
                        </div>
                    </div>
                    <div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>Test which is a new approach to have all
                                solutions</p>
                            <span class="time_date"> 11:01 AM    |    June 9</span>
                        </div>
                    </div>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" class="write_msg" placeholder="Type a message" />
                        <button class="upload_file_btn"><input type="file"></button>
                        <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
