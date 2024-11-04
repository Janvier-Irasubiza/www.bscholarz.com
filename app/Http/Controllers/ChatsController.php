<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatsController extends Controller
{
    function  index() {
        return view('chats.chat');
    }
}
