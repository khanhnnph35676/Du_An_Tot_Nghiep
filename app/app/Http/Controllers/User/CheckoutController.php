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
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\MessOrder;
use App\Models\Point;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function storeCheckout()
    {

        $cart = session()->get('cart', []);
        $checkOrder = session()->get('checkOrder', []);
        $addresses = session()->get('addresses', []);
        $address = [];
        $user_id = Auth::user()->id ?? 0;
        if ($user_id == 0) {
            $address = Address::where('user_id', null)->get();
        } else {
            $address = Address::where('user_id', $user_id)->get();
        }

        $products = Product::get();
        $productVariants = ProductVariant::get();
        $payments = Payment::get();

        // Kiểm tra giỏ hàng rỗng

        if (!$checkOrder != []) {
            if (empty($cart)) {
                return redirect()->route('storeHome');
            }
            $checkSelect = false; // Biến kiểm tra có ít nhất 1 sản phẩm được chọn
            foreach ($cart as $value) {
                if ($value['selected_products'] == 1 && $value['user_id'] == $user_id) {
                    $checkSelect = true;
                    break;
                }
            }
            // Nếu không có sản phẩm nào được chọn, chuyển hướng về trang chủ
            if (!$checkSelect) {
                return redirect()->route('storeHome');
            }
        }
        if ($checkOrder) {
            return redirect()->route('successCheckout');
        }
        $listVouchers = Voucher::get();
        $point = Point::where('user_id', $user_id)->first();
        $user_voucher = UserVoucher::with('voucher')->where('user_id', $user_id)->where('qty', '>', '0')->get();

        return view('user.cart.checkout')->with([
            'address' => $address,
            'cart' => $cart,
            'products' => $products,
            'productVariants' => $productVariants,
            'payments' => $payments,
            'addresses' => $addresses,
            'checkOrder' => $checkOrder,
            'listVouchers' => $listVouchers,
            'point' => $point,
            'user_voucher' => $user_voucher,
        ]);
    }

    function execPostRequest($url, $data)
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


    public function AddOrder(Request $request)
    {
        $request->validate([
            'sum_price' => 'required|min:1',
            'selected_address' => 'required|exists:address,id',
            'email' => 'required|email|max:50',
            'phone' => 'required|digits:10',
            'name' => 'required|max:50'
        ], [
            'sum_price.required' => 'Không có giá',
            'sum_price.min' => 'Tổng giá trị phải lớn hơn 0.',

            'selected_address.required' => 'Vui lòng chọn địa chỉ giao hàng.',
            'address_id.exists' => 'Địa chỉ giao hàng không hợp lệ.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn một email khác.',
            'email.max' => 'Bạn nhập tên dài quá 50 ký tự',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số.',

            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Bạn nhập tên dài quá 50 ký tự',

        ]);
        if (!Auth::check()) {
            $request->validate([
                'email' => 'unique:users,email',
            ], [
                'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn một email khác.',
            ]);
        }
        function generateRandomCode($length = 8)
        {
            return strtoupper(substr(md5(uniqid(rand(), true)), 0, $length));
        }
        $cart = session()->get('cart', []);
        $addresses = session()->get('addresses', []);
        $checkOrder = session()->get('checkOrder', []);

        //   tính giá kho có voucher
        $voucher = Voucher::find($request->voucher_id);
        $sum_price = $request->sum_price;
        if ($voucher != null) {
            if ($voucher->sale == 0) {
                $sum_price = $request->sum_price - 15000;
            } else {
                $sum_price = $request->sum_price - $request->sum_price * $voucher->sale / 100;
            }
        }

        $order = [
            'payment_id' => $request->payment_id,
            'status' => 0,
            'sum_price' => $sum_price,
            'address_id' => $request->selected_address,
            'check_payment_id' => 0,
            'order_code' => generateRandomCode(),
            'voucher_id' => $request->voucher_id,
        ];

        // $user = [];
        $addOrder = Order::create($order);
        $user_id = Auth::user()->id ?? null;
        $check_user = Auth::user() ? 1 : 0;
        if ($user_id == null) {
            $data_user = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'rule_id' => 2,
                'password' => Hash::make($request->pass)
            ];
            $user = User::create($data_user);

            foreach ($cart as $key => $value) {
                if ($value['selected_products'] == 1 && $value['user_id'] == $user_id) {
                    $value['product_variant_id'] = 0 ? $product_variant_id =  null : $product_variant_id = $value['product_variant_id'];
                    $discount = DiscountProduct::with('discounts')
                    ->where('product_id', $value['product_id'])->first();
                    // Nếu sản phẩm có biến thể, kiểm tra và trừ kho
                    if ($value['product_variant_id'] != 0) {
                        $product_variant = ProductVariant::find($product_variant_id);
                        if ($product_variant && $product_variant->stock >= 0 && $product_variant->stock - $value['qty'] >= 0) {
                            $product_variant->stock -= $value['qty'];
                            $product_variant->save();
                            $price =$product_variant->price;
                            if($discount !=null){
                                $price =  $product_variant->price - ($product_variant->price* $discount->discounts->discount)/100;
                            }
                            $dataProducts = [
                                'order_id' => $addOrder->id,  // ID đơn hàng
                                'product_id' => $value['product_id'],
                                'product_variant_id' =>  $value['product_variant_id'],
                                'quantity' => $value['qty'],
                                'price' => $price
                            ];
                            ProductOder::create($dataProducts);
                        } else {
                            return redirect()->back()->with([
                                'error' => 'Sản phẩm không đủ số lượng.'
                            ]);
                        }
                    } else {
                        $product = Product::find($value['product_id']);
                        if ($product && $product->qty >= 0 || $product->qty - $value['qty'] >= 0) {
                            $product->qty -= $value['qty'];
                            $product->save();
                            $price =$product->price;
                            if($discount !=null){
                                $price =  $product->price - ($product->price* $discount->discounts->discount)/100;
                            }
                            $dataProducts = [
                                'order_id' => $addOrder->id,  // ID đơn hàng
                                'product_id' => $value['product_id'],
                                'product_variant_id' =>  $product_variant_id,
                                'quantity' => $value['qty'],
                                'price' => $price
                            ];
                            ProductOder::create($dataProducts);
                        } else {
                            return redirect()->back()->with([
                                'error' => 'Sản phẩm không đủ số lượng.'
                            ]);
                        }
                    }
                    // làm giảm số giảm giá khi khách đặt hàng
                    if ($value['discount_id'] != 0) {
                        $discount = Discount::find($value['discount_id']);
                        $discount->update([
                            'qty' => $discount->qty + $value['qty']
                        ]);
                    }
                    unset($cart[$key]);
                }
            }
            // sửa địa chỉ có user_id null thành id
            $address = Address::where('user_id', NULL)->get();
            foreach ($address as $value) {
                $value->update([
                    'user_id' => $user->id
                ]);
            }
            foreach ($cart as $key => $value) {
                if ($user_id == 0) {
                    $cart[$key]['user_id'] = $user->id;
                }
            }
            $dataOrderList = [
                'order_id' => $addOrder->id,
                'user_id' => $user->id,
                'check_user' => $check_user,
            ];
            OrderList::create($dataOrderList);

            $dataCheck = [
                'order_id' => $addOrder->id,
                'user_id' => $user->id,
                'payment_id' => $request->payment_id,
                'voucher_id' => $request->voucher_id,
            ];
            $checkOrder[] = $dataCheck;
            MessOrder::create([
                'order_id' => $addOrder->id,
                'user_id' => $user->id,
            ]);
            Auth::login($user);
            // Phần gửi mail khi không có tài khoản
        } else {
            $user = User::find($user_id);
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
            $dataOrderList = [
                'order_id' => $addOrder->id,
                'user_id' => $user_id,
                'check_user' => $check_user,
            ];
            OrderList::create($dataOrderList);
            $dataCheck = [
                'order_id' => $addOrder->id,
                'user_id' => $user_id,
                'payment_id' => $request->payment_id,
                'voucher_id' => $request->voucher_id,
            ];
            $checkOrder[] = $dataCheck;
            MessOrder::create([
                'order_id' => $addOrder->id,
                'user_id' => $user_id,
            ]);
            foreach ($cart as $key => $value) {
                if ($value['selected_products'] == 1 && $value['user_id'] == $user_id) {
                    $value['product_variant_id'] = 0 ? $product_variant_id =  null : $product_variant_id = $value['product_variant_id'];
                    $discount = DiscountProduct::with('discounts')
                    ->where('product_id', $value['product_id'])->first();
                    // Nếu sản phẩm có biến thể, kiểm tra và trừ kho
                    if ($value['product_variant_id'] != 0) {
                        $product_variant = ProductVariant::find($product_variant_id);
                        if ($product_variant && $product_variant->stock >= 0 && $product_variant->stock - $value['qty'] >= 0) {
                            $product_variant->stock -= $value['qty'];
                            $product_variant->save();
                            $price =$product_variant->price;
                            if($discount !=null){
                                $price =  $product_variant->price - ($product_variant->price* $discount->discounts->discount)/100;
                            }
                            $dataProducts = [
                                'order_id' => $addOrder->id,  // ID đơn hàng
                                'product_id' => $value['product_id'],
                                'product_variant_id' =>  $value['product_variant_id'],
                                'quantity' => $value['qty'],
                                'price' => $price
                            ];
                            ProductOder::create($dataProducts);
                        } else {
                            return redirect()->back()->with([
                                'error' => 'Sản phẩm không đủ số lượng.'
                            ]);
                        }
                    } else {
                        $product = Product::find($value['product_id']);
                        if ($product && $product->qty >= 0 || $product->qty - $value['qty'] >= 0) {
                            $product->qty -= $value['qty'];
                            $product->save();
                            $price =$product->price;
                            if($discount !=null){
                                $price =  $product->price - ($product->price* $discount->discounts->discount)/100;
                            }
                            $dataProducts = [
                                'order_id' => $addOrder->id,  // ID đơn hàng
                                'product_id' => $value['product_id'],
                                'product_variant_id' =>  $product_variant_id,
                                'quantity' => $value['qty'],
                                'price' => $price
                            ];
                            ProductOder::create($dataProducts);
                        } else {
                            return redirect()->back()->with([
                                'error' => 'Sản phẩm không đủ số lượng.'
                            ]);
                        }
                    }
                    // làm giảm số giảm giá khi khách đặt hàng
                    if ($value['discount_id'] != 0) {
                        $discount = Discount::find($value['discount_id']);
                        $discount->update([
                            'qty' => $discount->qty + $value['qty']
                        ]);
                    }
                    unset($cart[$key]);
                }
            }
            if ($request->voucher_id != null) {
                $user_voucher = UserVoucher::where('voucher_id', $request->voucher_id)->where('user_id', $user_id)->first();
                $user_voucher->update([
                    'qty' => $user_voucher->qty - 1
                ]);
            }
        }

        // đối với khách chưa có tài khoản

        $emailUser = $request->email;
        $nameUser = $request->name;
        $userSearch = User::where('email', $emailUser)->first();

        //    Mail cho khách đặt hàng / tính cá không đăng nhập và đăng nhập

        $orders = Order::with('address', 'payments')->find($addOrder->id);
        $orderList = OrderList::where('order_id', $orders->id)->first();
        $productOrders = ProductOder::with('products', 'product_variants')->where('order_id', $orders->id)->get();
        $point = Point::where('user_id', $userSearch->id)->first();
        if ($point) {
            $point->update([
                'point' => ceil($point->point + ($orders->sum_price - 15000) / 1000),
            ]);
        } else {
            Point::create([
                'user_id' => $userSearch->id,
                'point' =>  ceil(($orders->sum_price - 15000) / 1000),
            ]);
        }
        $titleMail = "Đặt hàng thành công";
        Mail::send('user.email.success-checkout', compact('orders', 'userSearch', 'productOrders', 'orderList'), function ($email) use ($titleMail, $emailUser) {
            $email->to($emailUser)->subject($titleMail);
            $email->from($emailUser, $titleMail);
        });

        // thêm điểm

        session()->put('checkOrder', $checkOrder);
        session()->put('cart', $cart);
        session()->forget('addresses');
        if ($request->payment_id == 1) {
            return redirect()->route('successCheckout')->with([
                'message' => 'Chúc mừng thanh toán thành công qua COD'
            ]);
        } elseif ($request->payment_id == 2) {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderInfo = "Thanh toán qua MoMo";
            $amount =  $sum_price;
            $orderId = $addOrder->order_code;

            $redirectUrl = "http://127.0.0.1:8000/success-checkout";
            $ipnUrl = "http://127.0.0.1:8000/success-checkout";
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
            $result =  $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
            return redirect()->to($jsonResult['payUrl']);
        } else {
            $vnp_Url = env("VNPAY_URL");
            $vnp_Returnurl = "http://127.0.0.1:8000/success-checkout";
            $vnp_TmnCode = env('VNPAY_TMN_CODE'); // Mã website tại VNPAY
            $vnp_HashSecret = env('VNPAY_HASH_SECRET'); // Chuỗi bí mật
            $vnp_TxnRef = $addOrder->order_code;
            $vnp_OrderInfo = 'Thanh toan don hang';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $sum_price * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // 127.0.0.1


            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                // "vnp_ExpireDate" => $vnp_ExpireDate, // Đặt thời gian hết hạn
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            // Sắp xếp dữ liệu theo thứ tự chữ cái
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";

            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            // Tạo URL để chuyển hướng người dùng đến cổng thanh toán
            $vnp_Url = $vnp_Url . "?" . $query;

            if (isset($vnp_HashSecret)) {
                // Tạo mã hash bảo mật
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            // dd($vnp_Url);
            // Chuyển hướng người dùng đến cổng thanh toán nếu bấm nút redirect
            return redirect($vnp_Url);
        }
    }
    public function successCheckout()
    {
        $cart = session()->get('cart', []);
        $checkOrder = session()->get('checkOrder', []);
        $order = [];
        $productOrders = [];

        foreach ($checkOrder as $value) {
            $user_voucher =[];
            if($value['voucher_id'] != null){
                $user_voucher = UserVoucher::where('voucher_id', $value['voucher_id'])->where('user_id', $value['user_id'])->first();
            }

            $order = Order::with('address', 'payments')->find($value['order_id']);
            $productOrders = ProductOder::with('products', 'product_variants')
                ->where('order_id', $value['order_id'])->get();
            // check xem thanh toán thành công hay thất bại
            if (isset($_GET['resultCode']) && $_GET['resultCode'] != 1006 && $order->payment_id == 2) {
                $order->update([
                    'check_payment_id' => 1,
                ]);
            }
            if(isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] === '00' && $order->payment_id == 3){
                $order->update([
                    'check_payment_id' => 1,
                ]);
            }
        }

        return view('user.cart.succes-checkout', compact('cart', 'checkOrder', 'order', 'productOrders', 'user_voucher'));
    }
}
