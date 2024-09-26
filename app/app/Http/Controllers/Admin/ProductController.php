<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Giao diện
    public function listProducts(){
        return view('admin.product.list');
    }
    public function productDetail(){
        return view('admin.product.detail');
    }
}
