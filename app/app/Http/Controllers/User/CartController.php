<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;

use function Psy\bin;

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
            // Kiểm tra biến thể sản phẩm
            if (
                $item['user_id'] === $user_id &&
                $item['product_id'] == $product_id &&
                $item['product_variant_id'] == $product_variant_id &&
                $item['product_variant_id'] != 0
            ) {
                // Nếu là biến thể, kiểm tra tồn kho và cập nhật
                $productVariant = ProductVariant::find($item['product_variant_id']);
                if ($productVariant->stock > 0 && $productVariant->stock - $new_qty >= 0 && $new_qty <= 50) {
                    // $productVariant->update(['stock' => ($productVariant->stock + $item['qty']) - $new_qty]);
                    $item['qty'] = $new_qty;
                    $updated = true;
                } else {
                    return response()->json(['success' => false, 'message' => 'Không đủ số lượng trong kho cho biến thể này hoặc vượt quá 50.']);
                }
                break;
            } elseif ($item['product_variant_id'] == 0 && $item['user_id'] === $user_id && $item['product_id'] == $product_id) {
                $product = Product::find($item['product_id']);
                if ($product->qty > $new_qty && $new_qty <= 50) {
                    $item['qty'] = $new_qty;
                    $updated = true;
                } else {
                    return response()->json(['success' => false, 'message' => 'Không đủ số lượng trong kho cho sản phẩm này hoặc vượt quá 50.']);
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
        $user_id = Auth::user()->id ?? 0;
        $productId = $request->input('product_id');
        $productVariantId = $request->input('product_variant_id', 0); // Mặc định là 0 nếu không gửi
        $selected = $request->input('selected');

        $cart = session()->get('cart', []);

        $productUpdated = false;
        foreach ($cart as $index => $item) {
            if (
                $item['product_id'] == $productId &&
                $item['user_id'] == $user_id &&
                $item['product_variant_id'] == $productVariantId
            ) {
                $cart[$index]['selected_products'] = $selected;
                $productUpdated = true;
                break;
            }
        }

        if (!$productUpdated) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Giỏ hàng đã được cập nhật.']);
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
                    $item['qty'] = $new_qty;
                    $updated = true;
                } elseif ($item['qty'] > $new_qty) {
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
                if ($productVariant->stock > 0 && $productVariant->stock - $new_qty >= 0) {
                    $item['qty'] = $new_qty;
                    $updated = true;
                    break;
                } elseif ($item['qty'] - $new_qty > 0) {
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

    public function addToCartDetai(Request $request, $checkAdd)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:50',
        ], [
            'qty.required' => 'Chưa nhập số lượng',
            'qty.integer' => 'Số lượng phải là một số nguyên',
            'qty.min' => 'Số lượng không hợp lệ',
            'qty.max' => 'Số lượng quá 50',
        ]);
        $product = Product::find($request->product_id);
        if ($product->type == 1) {
            $request->validate([
                'qty' => 'lte:qty',
            ], [
                'product_qty.gte' => 'Số lượng trong kho không đủ so với số lượng bạn nhập'
            ]);
        } else {
            $request->validate([
                'qty' => 'lte:stock',
                'product_variant_id' => 'required',
            ], [
                'qty.lte' => 'Số lượng trong kho không đủ so với số lượng bạn nhập',
                'product_variant_id.required' => 'Vui lòng chọn một biến thể trước khi thêm vào giỏ hàng.',
            ]);
        }
        $user_id = Auth::id() ?? 0;
        if ($checkAdd == 1) {
            $data = [
                'user_id' => $user_id,
                'product_variant_id' => $request->product_variant_id ?? 0,
                'product_id' => $request->product_id,
                'qty' => (int)$request->qty,
                'selected_products' => $request->selected ?? false,
                'discount' => $request->discount ?? 0,
                'discount_id' => $request->discount_id ?? 0,
            ];
            // Xử lý giỏ hàng
            $cart = session()->get('cart', []);
            $productExists = false;
            foreach ($cart as $index => $item) {
                if (
                    $item['user_id'] === $data['user_id'] && $item['product_id'] === $data['product_id']
                    && $item['product_variant_id'] === $data['product_variant_id']
                ) {
                    if ($item['product_variant_id']  == 0) {
                        $product = Product::find($item['product_id']);
                        if ($request->qty + $item['qty'] <= $product->qty && $request->qty + $item['qty'] <= 50) {
                            $cart[$index]['qty'] += $data['qty'];
                            $cart[$index]['selected_products'] = $data['selected_products'];
                            $productExists = true;
                            break;
                        } else {
                            return redirect()->back()->with('error', 'Vượt quá số đơn trong giỏ hàng');
                        }
                    } else {
                        foreach ($cart as $index => $item) {
                            if (
                                $item['user_id'] === $data['user_id'] &&
                                $item['product_id'] === $data['product_id'] &&
                                $item['product_variant_id'] === $data['product_variant_id']
                            ) {
                                $productVariant = ProductVariant::find($item['product_variant_id']);
                                $newQty = $request->qty + $item['qty']; // Tính tổng trước

                                if ($newQty > 50) {
                                    return redirect()->back()->with('error', 'Tổng số lượng sản phẩm vượt quá 50!');
                                }

                                if ($newQty <= $productVariant->stock) {
                                    $cart[$index]['qty'] = $newQty; // Cộng chính xác
                                    $cart[$index]['selected_products'] = $data['selected_products'];
                                    $productExists = true;
                                    break;
                                } else {
                                    return redirect()->back()->with('error', 'Vượt quá số lượng tồn kho!');
                                }
                            }
                        }
                    }
                }
            }

            if (!$productExists) {
                $cart[] = $data;
                // $discount = Discount::get();
            }
            session()->put('cart', $cart);
            return redirect()->back()->with([
                'message' => 'Đặt hàng thành công',
            ]);
        } else {
            $data = [
                'user_id' => $user_id,
                'product_variant_id' => $request->product_variant_id ?? 0,
                'product_id' => $request->product_id,
                'qty' => (int)$request->qty,
                'selected_products' => 1,
                'discount' => $request->discount ?? 0,
                'discount_id' => $request->discount_id ?? 0,
            ];
            // Xử lý giỏ hàng
            $cart = session()->get('cart', []);
            $productExists = false;
            foreach ($cart as $index => $item) {
                if (
                    $item['user_id'] === $data['user_id'] && $item['product_id'] === $data['product_id']
                    && $item['product_variant_id'] === $data['product_variant_id']
                ) {
                    if ($item['product_variant_id']  == 0) {
                        $product = Product::find($item['product_id']);
                        if ($request->qty + $item['qty'] <= $product->qty && $request->qty + $item['qty'] <= 50) {
                            $cart[$index]['qty'] += $data['qty'];
                            $cart[$index]['selected_products'] = $data['selected_products'];
                            $productExists = true;
                            break;
                        } else {
                            return redirect()->back()->with('error', 'Vượt quá số đơn trong giỏ hàng');
                        }
                    } else {
                        foreach ($cart as $index => $item) {
                            if (
                                $item['user_id'] === $data['user_id'] &&
                                $item['product_id'] === $data['product_id'] &&
                                $item['product_variant_id'] === $data['product_variant_id']
                            ) {
                                $productVariant = ProductVariant::find($item['product_variant_id']);
                                $newQty = $request->qty + $item['qty']; // Tính tổng trước

                                if ($newQty > 50) {
                                    return redirect()->back()->with('error', 'Tổng số lượng sản phẩm vượt quá 50!');
                                }

                                if ($newQty <= $productVariant->stock) {
                                    $cart[$index]['qty'] = $newQty; // Cộng chính xác
                                    $cart[$index]['selected_products'] = $data['selected_products'];
                                    $productExists = true;
                                    break;
                                } else {
                                    return redirect()->back()->with('error', 'Vượt quá số lượng tồn kho!');
                                }
                            }
                        }
                    }
                }
            }

            if (!$productExists) {
                $cart[] = $data;
                // $discount = Discount::get();
            }
            session()->put('cart', $cart);
            return redirect()->route('storeCheckout')->with([
                'message' => 'Đặt hàng thành công',
            ]);
        }
    }

    public function removeItemCart($product_variant_id)
    {
        $user_id = Auth::user()->id ?? 0;
        $cart = session()->get('cart', []);

        $productVariant = ProductVariant::find($product_variant_id);
        foreach ($cart as $index => $item) {
            if ($item['product_variant_id'] == $product_variant_id && $item['user_id'] == $user_id) {
                unset($cart[$index]);
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
    public function removeItemCartDetail($product_id)
    {
        $user_id = Auth::user()->id ?? 0;
        $product = Product::find($product_id);
        $cart = session()->get('cart', []);

        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $product_id && $item['user_id'] == $user_id) {
                unset($cart[$index]);
            }
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($product->type == 1) {
            $request->validate([
                'qty' => 'lte:qty',
            ], [
                'product_qty.gte' => 'Số lượng trong kho không đủ so với số lượng bạn nhập'
            ]);
        } else {
            $request->validate([
                'qty' => 'lte:stock',
            ], [
                'qty.lte' => 'Số lượng trong kho không đủ so với số lượng bạn nhập'
            ]);
        }
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
            'product_variant_id' => $hasVariant ? $request->product_variant_id : 0,
            'product_id' => $request->product_id,
            'qty' => (int)$request->qty,
            'selected_products' => $request->selected ?? false,
            'discount' => $request->discount ?? 0,
            'discount_id' => $request->discount_id ?? 0,
            // 'voucher_id' => $request->voucher_id,
            // 'voucher_sale' => $request->voucher_sale,
            // 'qty_voucher' => $request->qty_voucher,
        ];
        // dd($data);
        // Xử lý giỏ hàng
        $cart = session()->get('cart', []);
        $productExists = false;

        foreach ($cart as $index => $item) {
            if (
                $item['user_id'] === $data['user_id'] && $item['product_id'] === $data['product_id']
                && $item['product_variant_id'] === $data['product_variant_id']
            ) {
                if ($item['product_variant_id']  == 0) {
                    $product = Product::find($item['product_id']);
                    if ($request->qty + $item['qty'] <= $product->qty && $request->qty + $item['qty'] <= 50) {
                        $cart[$index]['qty'] += $data['qty'];
                        $cart[$index]['selected_products'] = $data['selected_products'];
                        $productExists = true;
                        break;
                    } else {
                        return redirect()->back()->with('error', 'Vượt quá số đơn trong giỏ hàng');
                    }
                } else {
                    foreach ($cart as $index => $item) {
                        if (
                            $item['user_id'] === $data['user_id'] &&
                            $item['product_id'] === $data['product_id'] &&
                            $item['product_variant_id'] === $data['product_variant_id']
                        ) {
                            $productVariant = ProductVariant::find($item['product_variant_id']);
                            $newQty = $request->qty + $item['qty']; // Tính tổng trước

                            if ($newQty > 50) {
                                return redirect()->back()->with('error', 'Tổng số lượng sản phẩm vượt quá 50!');
                            }

                            if ($newQty <= $productVariant->stock) {
                                $cart[$index]['qty'] = $newQty; // Cộng chính xác
                                $cart[$index]['selected_products'] = $data['selected_products'];
                                $productExists = true;
                                break;
                            } else {
                                return redirect()->back()->with('error', 'Vượt quá số lượng tồn kho!');
                            }
                        }
                    }
                }
            }
        }

        if (!$productExists) {
            $cart[] = $data;
            // $discount = Discount::get();
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }
}
