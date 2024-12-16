<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductOder;
use App\Models\Voucher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserOrderController extends Controller
{
    public function index()
    {
        session()->forget('checkOrder');
        $user_id = Auth::user()->id;
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
    public function detail($order_id)
    {
        session()->forget('checkOrder');
        $user_id = Auth::user()->id;
        $orderLists = OrderList::with('orders', 'orders.address', 'users')
        ->where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->get();
        $productOrders =  ProductOder::with('products', 'product_variants')
        ->where('order_id',$order_id)
        ->get();
        $user =User::find($user_id);
        $orderList = OrderList::with('orders', 'orders.address','orders.payments')
        ->where('user_id', $user_id)
        ->where('order_id',$order_id)
        ->first();
        $cart = session()->get('cart', []);
        $order = Order::find($order_id);
        $voucher = Voucher::find($order->voucher_id);
        return view('user.cart.detail')->with([
            'cart' => $cart,
            'orderLists' => $orderLists,
            'productOrders' =>$productOrders,
            'user' => $user,
            'orderList' => $orderList,
            'voucher' => $voucher,
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
