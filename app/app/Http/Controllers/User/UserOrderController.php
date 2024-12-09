<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductOder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserOrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id ?? null;
        $orderLists = OrderList::with('orders', 'orders.address', 'users')
        ->where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->get();
        $productOrders =  ProductOder::with('products', 'product_variants')->get();

        $cart = session()->get('cart', []);
        return view('user.order-history')->with([
            'cart' => $cart,
            'orderLists' => $orderLists,
            'productOrders' => $productOrders
        ]);
    }
    public function destroyOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->update([
            'status' => 5,
        ]);
        // $user_id = Auth::user()->id ?? null;
        $productOrders =  ProductOder::with('products', 'product_variants')->where('order_id',$order->id)->get();
        foreach($productOrders as $value){
            if($value->product_variant_id == null || $value->product_variant_id == 0){
                $product= Product::find($value->product_id);
                $product->update([
                    'qty' => $product->qty + $value->quantity,
                ]);
            }else{
                $productVariant= ProductVariant::find($value->product_variant_id);
                $productVariant->update([
                    'stock' => $productVariant->stock + $value->quantity,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'Đã huỷ đơn hàng',
        ]);
    }

}
