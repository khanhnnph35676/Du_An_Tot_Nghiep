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
    public function storeCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        $address = [];
        if (Auth::user()) {
            $address = Address::where('user_id', Auth::user()->id)->get();
        } else {
            $address = [];
            return redirect()->intended('');
        }
        // $selectedProductIds = $request->input('selected_products', []);
        $products = Product::get();
        // whereIn('id', $selectedProductIds)->
        $productVariants = ProductVariant::get();
        $payments = Payment::get();
        return view('user.cart.checkout')->with([
            'address' => $address,
            'cart' => $cart,
            'products' => $products,
            'productVariants' => $productVariants,
            'payments' => $payments
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
        // $request->validate([
        //     'sum_price' => 'required|min:1',  // Kiểm tra giá trị là số và lớn hơn 0
        //     'address_id' => 'required|exists:addresses,id',  // Kiểm tra address_id có tồn tại trong bảng addresses
        //     'email' => 'required|email',  // Kiểm tra email hợp lệ
        //     'phone' => 'required|min:10',  // Kiểm tra phone là số và có ít nhất 10 chữ số
        //     'payment_id' => 'required',  // Kiểm tra payment_id có giá trị hợp lệ (ví dụ COD, credit_card, bank_transfer)
        // ]);
        function generateRandomCode($length = 8)
        {
            return strtoupper(substr(md5(uniqid(rand(), true)), 0, $length));
        }

        if ($request->payment_id == 1) {
            $order = [
                'payment_id' => $request->payment_id,
                'status' => 1,
                'sum_price' => $request->sum_price,
                'address_id' => $request->selected_address,
                'order_code' => generateRandomCode(),
            ];

            $addOrder = Order::create($order);
            $orderList = [
                'order_id' => $addOrder->id,
                'user_id' => Auth::user()->id,
            ];
            OrderList::create($orderList);
            // Lấy tất cả các sản phẩm

            $cart = session()->get('cart', []);
            foreach ($cart as $key => $value) {
                if (Auth::user()->id == $value['user_id']) {
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
            $orderList = [
                'order_id' => $addOrder->id,
                'user_id' => Auth::user()->id,
            ];
            OrderList::create($orderList);
            // Lấy tất cả các sản phẩm

            $cart = session()->get('cart', []);
            foreach ($cart as $key => $value) {
                if (Auth::user()->id == $value['user_id']) {
                    $products = [
                        'order_id' => $addOrder->id,  // ID đơn hàng
                        'product_id' => $value['product_id'],
                        'product_variant_id' =>  $value['product_variant_id'],
                        'quantity' => $value['qty'],
                        'price' => $request->price
                    ];
                    // Tạo một bản ghi mới cho mỗi sản phẩm
                    ProductOder::create($products);
                    unset($cart[$key]);
                }
            }
            session()->put('cart', $cart);
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
