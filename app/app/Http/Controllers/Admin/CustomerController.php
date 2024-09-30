<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Giao diện Customer
    public function listCustomer(){
        return view('admin.customer.list');
    }
    public function customerDetail(){
        return view('admin.customer.detail');
    }
}
