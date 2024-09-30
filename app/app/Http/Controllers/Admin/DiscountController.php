<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function listDiscounts(){
        return view('admin.discount.list');
    }
    public function discountDetail(){
        return view('admin.discount.detail');
    }
}
