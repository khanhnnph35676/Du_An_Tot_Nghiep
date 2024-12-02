<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function updateQtyCartVariant(Request $request)
    {
        $user_id = Auth::id() ?? 0;
        $product_id = $request->product_id;
        $product_variant_id = $request->product_variant_id;
        $new_qty = (int)$request->qty;

        // Kiểm tra số lượng
        if ($new_qty <= 0) {
            return response()->json(['success' => false, 'message' => 'Số lượng phải lớn hơn 0.']);
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        $updated = false;
        foreach ($cart as &$item) {
            $productVariant = ProductVariant::find($item['product_variant_id']);
            $product =  Product::find($item['product_id']);
            if (
                $item['user_id'] === $user_id &&
                $item['product_id'] == $product_id &&
                $item['product_variant_id']  == $product_variant_id &&
                $item['product_variant_id'] != ''
            ) {
                if (($productVariant->stock + $item['qty']) >= $new_qty && $new_qty <= 50) {
                    $productVariant->update(['stock' => ($productVariant->stock + $item['qty']) - $new_qty]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                }
                break;
            }
            elseif (empty($item['product_variant_id']))
            {
                if (($product->qty + $item['qty']) >= $new_qty && $new_qty <= 50) {
                    $product->update(['qty' => ($product->qty + $item['qty']) - $new_qty]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                }
                break;
            }
        }

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Không đủ số lượng trong kho hoặc bạn đang nhập quá 50 số lượng.']);
        }

        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công.']);
    }




    public function updateSelectedProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $selected = $request->input('selected'); // 1 nếu chọn, 0 nếu bỏ chọn

        // Kiểm tra nếu sản phẩm id và selected đã được gửi đúng
        if (!$productId || !isset($selected)) {
            return response()->json(['error' => 'Dữ liệu không hợp lệ'], 400);
        }

        // Lấy giỏ hàng hiện tại từ session
        $cart = session()->get('cart', []);

        $productUpdated = false;
        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $productId) {
                $cart[$index]['selected_products'] = $selected; // Cập nhật selected_products
                $productUpdated = true;
                break;
            }
        }

        if (!$productUpdated) {
            // Nếu sản phẩm không có trong giỏ, thêm mới
            $cart[] = [
                'product_id' => $productId,
                'selected_products' => $selected
            ];
        }

        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);

        return response()->json(['message' => 'Giỏ hàng đã được cập nhật.']);
    }
    public function updateCartNonVariant(Request $request)
    {
        $user_id = Auth::id() ?? 0;
        $product_id = $request->product_id;
        $new_qty = (int)$request->qty;

        // Kiểm tra số lượng
        if ($new_qty <= 0) {
            return response()->json(['success' => false, 'message' => 'Số lượng phải lớn hơn 0.']);
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        $updated = false;
        $product = Product::find($request->product_id);
        foreach ($cart as &$item) { // Thêm tham chiếu & để sửa trực tiếp mảng
            if (
                $item['user_id'] === $user_id &&
                $item['product_id'] == $product_id
            ) {
                if ($product->qty > 0 && $item['qty'] < $new_qty) {
                    $product->update(['qty' => $product->qty - 1]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                } elseif ($item['qty'] > $new_qty) {
                    $product->update(['qty' => $product->qty + 1]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                } else {
                    $updated = false;
                }
                break;
            }
        }
        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm đã hết']);
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công.']);
    }

    public function updateCart(Request $request)
    {
        $user_id = Auth::id() ?? 0;
        $product_id = $request->product_id;
        $product_variant_id = $request->product_variant_id;
        $new_qty = (int)$request->qty;

        if ($new_qty <= 0) {
            return response()->json(['success' => false, 'message' => 'Số lượng phải lớn hơn 0.']);
        }

        $cart = session()->get('cart', []);
        $updated = false;

        foreach ($cart as &$item) {
            $productVariant = ProductVariant::find($item['product_variant_id']);
            if (
                $item['user_id'] === $user_id &&
                $item['product_id'] == $product_id &&
                $item['product_variant_id'] == $product_variant_id
            ) {
                if ($productVariant->stock > 0 && $item['qty'] - $new_qty < 0) {
                    $productVariant->update(['stock' => $productVariant->stock - 1]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                    break;
                } elseif ($item['qty'] - $new_qty > 0) {
                    $productVariant = ProductVariant::find($item['product_variant_id']);
                    $productVariant->update(['stock' => $productVariant->stock + 1]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                    break;
                } else {
                    $updated = false;
                    break;
                }
                $updated = false;
                break;
            }
        }

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm đã hết']);
        }

        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công.']);
    }

    public function addToCart(Request $request)
    {
        $user_id = Auth::id() ?? 0;

        // Kiểm tra nếu sản phẩm có biến thể
        $hasVariant = $request->has('product_variant_id') && $request->product_variant_id;

        if ($hasVariant) {
            $request->validate([
                'product_variant_id' => 'required',
            ], [
                'product_variant_id.required' => 'Vui lòng chọn một biến thể trước khi thêm vào giỏ hàng.',
            ]);
        }

        // Dữ liệu giỏ hàng
        $data = [
            'user_id' => $user_id,
            'product_variant_id' => $hasVariant ? $request->product_variant_id : null,
            'product_id' => $request->product_id,
            'qty' => (int)$request->qty,
            'selected_products' => $request->selected ?? false,
        ];

        // Nếu sản phẩm có biến thể, kiểm tra và trừ kho
        if ($hasVariant) {
            $product_variant = ProductVariant::find($request->product_variant_id);
            if ($product_variant && $product_variant->stock > 0) {
                $product_variant->stock -= 1;
                $product_variant->save();
            } else {
                return response()->json(['error' => 'Sản phẩm không đủ số lượng.'], 400);
            }
        } else {
            $product = Product::find($request->product_id);
            if ($product && $product->qty > 0) {
                $product->qty -= 1;
                $product->save();
            }
        }

        // Xử lý giỏ hàng
        $cart = session()->get('cart', []);
        $productExists = false;

        foreach ($cart as $index => $item) {
            if (
                $item['user_id'] === $data['user_id'] &&
                $item['product_id'] === $data['product_id'] &&
                $item['product_variant_id'] === $data['product_variant_id']
            ) {
                $cart[$index]['qty'] += $data['qty'];
                $cart[$index]['selected_products'] = $data['selected_products'];
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
        $productVariant = ProductVariant::find($product_variant_id);
        foreach ($cart as $index => $item) {
            if ($item['product_variant_id'] == $product_variant_id) {
                $productVariant->update([
                    'stock' => $productVariant->stock + $item['qty']
                ]);
                unset($cart[$index]);
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
    public function removeItemCartDetail($product_id)
    {
        $product = Product::find($product_id);
        $cart = session()->get('cart', []);
        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $product_id) {
                $product->update([
                    'qty' => $product->qty + $item['qty']
                ]);
                unset($cart[$index]);
            }
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
}
