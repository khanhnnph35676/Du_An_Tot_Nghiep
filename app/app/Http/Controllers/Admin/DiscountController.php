<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Gallerie;
use App\Models\DiscountProduct;
use App\Models\ProductVariant;
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
        $galleries = Gallerie::get();
        $variants = ProductVariant::get();
        $products = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        return view('admin.discount.create')->with([
            'products' => $products,
            'galleries' => $galleries,
            'variants' => $variants
        ]);
    }
    public function storeDiscount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0', // Discount phải là số dương
            'priority' => 'required|integer|min:1', // Priority phải là số nguyên dương
            'start_date' => 'required|date|date_format:Y-m-d', // Định dạng ngày phải là Y-m-d
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date', // Ngày kết thúc phải sau hoặc bằng ngày bắt đầu
        ]);
        $data = [
            'name' => $request->name,
            'discount' => $request->discount,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];
        if($request->start_date < $request->end_date){
            $discount = Discount::query()->create($data);
        }
        $name = $discount->name;
        if (is_array($request->product_id)) {
            foreach ($request->product_id as $value) {
                $dataDiscount = [
                    'product_id' => $value,
                    'name_discount' => $name
                ];
                DiscountProduct::create($dataDiscount);
            }
        }
        return redirect()->route('admin.listDiscounts')->with('message', 'Thêm dữ liệu thành công');
    }

    public function updateDiscount(Request $request)
    {
        $galleries = Gallerie::get();
        $variants = ProductVariant::get();
        $products = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        $discount = Discount::where('id', $request->id)->first();
        $discountProduct = DiscountProduct::where('name_discount',$discount->name)->get();
        return view('admin.discount.update', compact('discount','galleries','variants','products','discountProduct'));
    }
    public function update(Request $request)
    {
        $discountBefore = Discount::where('id', $request->id)->first();
        $discountProductBefore = DiscountProduct::where('name_discount', $discountBefore->name)->get();
        $data = [
            'name' => $request->name,
            'discount' => $request->discount,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];
        Discount::where('id', $request->id)->update($data);

        if (is_array($request->product_id)) {
            foreach ($request->product_id as $value) {
                foreach ($discountProductBefore as $itemDiscount) {
                    if($request->name !=  $discountBefore->name || $itemDiscount->product_id != $value){
                        $itemDiscount->delete();
                    }
                }
                $dataDiscount = [
                    'product_id' => $value,
                    'name_discount' => $request->name
                ];
                DiscountProduct::create($dataDiscount);
            }
        }else{
            DiscountProduct::where('name_discount', $discountBefore->name)->delete();
        }
        return redirect()->route('admin.listDiscounts')->with('message', 'Cập nhật dữ liệu thành công');
    }

    public function destroy(Request $request)
    {
        $discount = Discount::find($request->id);
        $discount->delete();
        return redirect()->route('admin.listDiscounts')->with('message', 'Xóa dữ liệu thành công');
    }
}
