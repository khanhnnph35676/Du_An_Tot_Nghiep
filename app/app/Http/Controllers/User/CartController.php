<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $request->validate([
            'product_variant_id' => 'required',
        ], [
            'product_variant_id.required' => 'Vui lòng chọn một biến thể trước khi thêm vào giỏ hàng.',
        ]);
        $data = [
            'product_variant_id' => $request->product_variant_id,
            'product_id' => $request->product_id
        ];
    // Lấy giỏ hàng hiện tại từ session, nếu chưa có thì khởi tạo một mảng rỗng
    $cart = session()->get('cart', []);
    // Thêm sản phẩm vào giỏ hàng
    $cart[] = $data;
    // Cập nhật giỏ hàng vào session
    session()->put('cart', $cart);
    return redirect()->back();
    }
}
