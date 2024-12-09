<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppController extends Controller
{
    // Giao diện các mục trong app
    public function calender(){
        return view('admin.app.calender');
    }
    public function profile(){
        return view('admin.app.profile');
    }
    public function inbox(){
        return view('admin.app.inbox');
    }
    public function compose(){
        return view('admin.app.compose');
    }
    public function readEmail(){
        return view('admin.app.read-email');
    }

}
