<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MessOrder;

class ChatController extends Controller
{
    public function index(){
        $users = User::get();
        $messages = MessOrder::with('user','order')->get();
        return view('admin.chat.list')->with([
            'users' => $users,
            'messages' => $messages
        ]);
    }
}
