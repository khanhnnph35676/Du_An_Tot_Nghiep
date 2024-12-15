<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MessOrder;
class AppController extends Controller
{
    // Giao diện các mục trong app
    public function calender(){
        $messages = MessOrder::with('user','order')->get();
        return view('admin.app.calender',compact('messages'));
    }
    public function profile(){
        $messages = MessOrder::with('user','order')->get();
        return view('admin.app.profile',compact('messages'));
    }
    public function inbox(){
        $messages = MessOrder::with('user','order')->get();
        return view('admin.app.inbox',compact('messages'));
    }
    public function compose(){
        $messages = MessOrder::with('user','order')->get();
        return view('admin.app.compose',compact('messages'));
    }
    public function readEmail(){
        $messages = MessOrder::with('user','order')->get();
        return view('admin.app.read-email',compact('messages'));
    }

}
