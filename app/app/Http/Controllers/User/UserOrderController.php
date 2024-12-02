<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\ProductOder;
use Illuminate\Http\Request;
class UserOrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id ?? null;
        $orderLists = OrderList::with('orders','orders.address' ,'users')->where('user_id',$user_id)->get();
        $productOrders =  ProductOder::with('products','product_variants')->get();
        $cart = session()->get('cart', []);
        return view('user.order-history')->with([
            'cart' => $cart,
            'orderLists' => $orderLists,
            'productOrders' => $productOrders
        ]);
    }
}
