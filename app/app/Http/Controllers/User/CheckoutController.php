<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderList;
use App\Models\ProductOder;
use App\Models\Product;
use App\Models\Address;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Redis;

class CheckoutController extends Controller
{
    public function storeCheckout()
    {
        $cart = session()->get('cart', []);
        $addresses = session()->get('addresses', []);

        $address = [];
        $user_id = Auth::user()->id ?? null;
        $address = Address::where('user_id', $user_id)->get();

        // $selectedProductIds = $request->input('selected_products', []);
        $products = Product::get();
        // whereIn('id', $selectedProductIds)->
        $productVariants = ProductVariant::get();
        $payments = Payment::get();
        // session()->forget('addresses');
        return view('user.cart.checkout')->with([
            'address' => $address,
            'cart' => $cart,
            'products' => $products,
            'productVariants' => $productVariants,
            'payments' => $payments,
            'addresses' => $addresses
        ]);
    }


    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momoPayment(Request $request) {}
    public function AddOrder(Request $request)
    {
        $request->validate([
            'sum_price' => 'required|min:1',  // Kiểm tra giá trị là số và lớn hơn 0
            'selected_address' => 'required|exists:address,id',  // Kiểm tra address_id có tồn tại trong bảng addresses
            'email' => 'required|email',  // Kiểm tra email hợp lệ
            'phone' => 'required|min:10',
            'name' => 'required'
        ], [
            'sum_price.required' => 'Không có giá',
            'sum_price.min' => 'Tổng giá trị phải lớn hơn 0.',
            'selected_address.required' => 'Vui lòng chọn địa chỉ giao hàng.',
            'address_id.exists' => 'Địa chỉ giao hàng không hợp lệ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
            'name.required' => 'Vui lòng nhập tên'
        ]);
        function generateRandomCode($length = 8)
        {
            return strtoupper(substr(md5(uniqid(rand(), true)), 0, $length));
        }
        $cart = session()->get('cart', []);
        $addresses = session()->get('addresses', []);
        if ($request->payment_id == 1) {
            $order = [
                'payment_id' => $request->payment_id,
                'status' => 1,
                'sum_price' => $request->sum_price,
                'address_id' => $request->selected_address,
                'order_code' => generateRandomCode(),
            ];

            $addOrder = Order::create($order);
            $user_id = Auth::user()->id ?? null;
            $check_user = Auth::user() ? 1 : 0;
            if ($user_id == null) {
                $user = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'rule_id' => 2,
                    'password' => 'adc123'
                ];
                $user = User::create($user);
                $orderList = [
                    'order_id' => $addOrder->id,
                    'user_id' => $user->id,
                    'check_user' => $check_user,
                ];
                OrderList::create($orderList);
            } else {
                $orderList = [
                    'order_id' => $addOrder->id,
                    'user_id' => $user_id,
                    'check_user' => $check_user,
                ];
                OrderList::create($orderList);
            }

            foreach ($cart as $key => $value) {
                if ($user_id == $value['user_id']) {
                    $product_variant_id = $value['product_variant_id'] ? $value['product_variant_id'] : null;
                    $products = [
                        'order_id' => $addOrder->id,  // ID đơn hàng
                        'product_id' => $value['product_id'],
                        'product_variant_id' =>  $product_variant_id,
                        'quantity' => $value['qty'],
                        'price' => $request->price
                    ];
                    // Tạo một bản ghi mới cho mỗi sản phẩm
                    ProductOder::create($products);
                    unset($cart[$key]);
                } else {
                    $product_variant_id = $value['product_variant_id'] ? $value['product_variant_id'] : null;
                    $products = [
                        'order_id' => $addOrder->id,  // ID đơn hàng
                        'product_id' => $value['product_id'],
                        'product_variant_id' =>  $product_variant_id,
                        'quantity' => $value['qty'],
                        'price' => $request->price
                    ];
                    // Tạo một bản ghi mới cho mỗi sản phẩm
                    ProductOder::create($products);
                    unset($cart[$key]);
                }
            }
            session()->put('cart', $cart);
            session()->forget('addresses');
            return redirect()->route('order.history')->with([
                'message' => 'Chúc mừng thanh toán thành công qua COD'
            ]);
        } else {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $order = [
                'payment_id' => $request->payment_id,
                'status' => 1,
                'sum_price' => $request->sum_price,
                'address_id' => $request->selected_address,
                'order_code' => generateRandomCode(),
            ];

            $addOrder = Order::create($order);
            $user_id = Auth::user()->id ?? null;
            $check_user = Auth::user() ? 1 : 0;
            // Lấy tất cả các sản phẩm
            if ($user_id == null) {
                $user = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone
                ];
                $user = User::create($user);
                $orderList = [
                    'order_id' => $addOrder->id,
                    'user_id' => $user->id,
                    'check_user' => $check_user,
                ];
                OrderList::create($orderList);
            } else {
                $orderList = [
                    'order_id' => $addOrder->id,
                    'user_id' => $user_id,
                    'check_user' => $check_user,
                ];
                OrderList::create($orderList);
            }
            $cart = session()->get('cart', []);
            foreach ($cart as $key => $value) {
                if ($user_id == $value['user_id']) {
                    $product_variant_id = $value['product_variant_id'] ? $value['product_variant_id'] : null;
                    $products = [
                        'order_id' => $addOrder->id,  // ID đơn hàng
                        'product_id' => $value['product_id'],
                        'product_variant_id' =>  $product_variant_id,
                        'quantity' => $value['qty'],
                        'price' => $request->price
                    ];
                    // Tạo một bản ghi mới cho mỗi sản phẩm
                    ProductOder::create($products);
                    unset($cart[$key]);
                } else {
                    $product_variant_id = $value['product_variant_id'] ? $value['product_variant_id'] : null;
                    $products = [
                        'order_id' => $addOrder->id,  // ID đơn hàng
                        'product_id' => $value['product_id'],
                        'product_variant_id' =>  $product_variant_id,
                        'quantity' => $value['qty'],
                        'price' => $request->price
                    ];
                    // Tạo một bản ghi mới cho mỗi sản phẩm
                    ProductOder::create($products);
                    unset($cart[$key]);
                }
            }
            session()->put('cart', $cart);
            session()->forget('addresses');
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua ATM MoMo";
            $amount = $request->sum_price;
            $orderId = $addOrder->order_code;
            $redirectUrl = "http://127.0.0.1:8000/store-checkout";
            $ipnUrl = "http://127.0.0.1:8000/store-checkout";
            $extraData = "";

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
            return redirect()->to($jsonResult['payUrl']);
            return redirect()->route('order.history')->with([
                'message' => 'Chúc mừng thanh toán thành công qua COD'
            ]);
        }
    }
}
