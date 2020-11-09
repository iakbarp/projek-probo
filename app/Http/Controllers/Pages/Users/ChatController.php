<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\User;

class ChatController extends Controller{

    public function index()
    {
        return view('pages.main.users.chat');
    }
}
