<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // giao diện
    public function listOrders(){
        return view('admin.order.list');
    }
    public function orderDetail(){
        return view('admin.order.detail');
    }

}
