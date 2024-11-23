<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\ProductOder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // giao diện
    public function listOrders(){
        $orderLists = OrderList::with('orders','orders.address' ,'users')
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.order.list')->with([
            'orderLists' => $orderLists
        ]);
    }
    public function orderDetail($order_id){
        if(Auth::check()){
            $orderList = OrderList::with(['orders', 'orders.address', 'users'])
            ->where('order_id', $order_id)
            ->get();
            $data = ProductOder::with('products','product_variants')->where('order_id',$order_id)->get();
        }
        return view('admin.order.detail')->with([
            'orderList' => $orderList,
            'data' => $data
        ]);
    }
    public function updateOrder($order_id,Request $request){
        $data =[
            'status' => $request->status
        ];
        $statusOrder = Order::find($order_id);
        $statusOrder->update($data);
        return redirect()->back()->with([
            'message' => 'Sửa trạng thái thành công'
        ]);
    }

}
