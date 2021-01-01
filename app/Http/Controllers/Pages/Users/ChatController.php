<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\messageController as ChatMassage;

class ChatController extends Controller{

    public function index()
    {
        $token = auth('api')->tokenById(Auth::id());
//        dd($token);
//        $chat = new ChatMassage();
//        dd($chat->index($token));
        return view('pages.main.users.chat');
    }
}
