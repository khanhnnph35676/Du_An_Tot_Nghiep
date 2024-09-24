<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenController extends Controller
{
// phần giao diện đăng nhập, đăng ký, đăng xuất
    public function loginAdmin(){
        return view('admin.login');
    }
    public function registerAdmin(){
        return view('admin.register');
    }
}
