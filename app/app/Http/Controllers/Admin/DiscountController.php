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
    public function createDiscount(){
        return view('admin.discount.create');
    }
    public function storeDiscount(Request $request)
    {
        $data = $request->all();
        // dd($data);

        Discount::query()->create($data);
        return redirect()->route('admin.listDiscounts')->with('message', 'Thêm dữ liệu thành công');
    }
}
