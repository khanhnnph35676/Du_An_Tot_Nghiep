<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function listDiscounts(){
        $discounts = Discount::all();
        // dd($discounts);
        return view('admin.discount.list', compact('discounts'));
    }
    public function discountDetail(){
        return view('admin.discount.detail');
    }
}
