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
        $orderLists = OrderList::with('orders','orders.address' ,'users')->get();
        $productOrders =  ProductOder::with('products','product_variants')->get();
        $cart = session()->get('cart', []);
        return view('user.order-history')->with([
            'cart' => $cart,
            'orderLists' => $orderLists,
            'productOrders' => $productOrders
        ]);
    }
}
