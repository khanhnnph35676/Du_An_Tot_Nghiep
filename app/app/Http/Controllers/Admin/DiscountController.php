<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function listDiscounts(){
        $discounts = Discount::get();
        $products =Product::get();
        // dd($discounts);
        return view('admin.discount.list', compact('discounts','products'));
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

    public function updateDiscount(Request $request)
    {
        $discount = Discount::where('id', $request->id)->first();
        return view('admin.discount.update', compact('discount'));
    }
    public function update(Request $request)
    {
        // $data = $request->all();
        $data = $request->except('_token', '_method','submit');

        // dd($data);
        Discount::where('id', $request->id)->update($data);
        return redirect()->back()->with('message', 'Cập nhật dữ liệu thành công');
    }

    public function destroy(Request $request)
    {
        $discount = Discount::find($request->id);
        $discount->delete();
        return redirect()->route('admin.listDiscounts')->with('message', 'Xóa dữ liệu thành công');
    }
}
