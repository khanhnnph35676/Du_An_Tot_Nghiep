<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user_id = Auth::id() ?? null;

        $request->validate([
            'product_variant_id' => 'required',
        ], [
            'product_variant_id.required' => 'Vui lòng chọn một biến thể trước khi thêm vào giỏ hàng.',
        ]);
        $data = [
            'user_id' => $user_id,
            'product_variant_id' => $request->product_variant_id,
            'product_id' => $request->product_id,
            'qty' => (int)$request->qty,
        ];
        $cart = session()->get('cart', []);
        $productExists = false;
        foreach ($cart as $index => $item) {
            if (
                $item['user_id'] === $data['user_id'] &&
                $item['product_id'] === $data['product_id'] &&
                $item['product_variant_id'] === $data['product_variant_id']
            ) {
                $cart[$index]['qty'] += $data['qty'];
                $productExists = true;
                break;
            }
        }
        if (!$productExists) {
            $cart[] = $data;
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }
    public function removeItemCart($product_variant_id)
    {
        $cart = session()->get('cart', []);
        foreach ($cart as $index => $item) {
            if ($item['product_variant_id'] == $product_variant_id) {
                unset($cart[$index]);
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
    public function removeItemCartDetail($product_id)
    {
        $cart = session()->get('cart', []);
        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart[$index]);
            }
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
}
