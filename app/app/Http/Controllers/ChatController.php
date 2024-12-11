<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class ChatController extends Controller
{
    public function index(){
        $users = User::get();
        return view('admin.chat.list')->with([
            'users' => $users
        ]);
    }
}
