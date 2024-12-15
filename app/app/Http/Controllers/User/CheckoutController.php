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
use App\Models\Point;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        if($checkOrder){
            return redirect()->route('successCheckout');
        }
        return view('user.cart.checkout')->with([
            'address' => $address,
            'cart' => $cart,
            'products' => $products,
            'productVariants' => $productVariants,
            'payments' => $payments,
            'addresses' => $addresses,
            'checkOrder' => $checkOrder,
        ]);
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
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
        // $request->validate([
        //     'sum_price' => 'required|min:1',
        //     'selected_address' => 'required|exists:address,id',
        //     'email' => 'required|email|max:50',
        //     'phone' => 'required|min:10|max:10',
        //     'name' => 'required|max:50'
        // ], [
        //     'sum_price.required' => 'Không có giá',
        //     'sum_price.min' => 'Tổng giá trị phải lớn hơn 0.',

        //     'selected_address.required' => 'Vui lòng chọn địa chỉ giao hàng.',
        //     'address_id.exists' => 'Địa chỉ giao hàng không hợp lệ.',

        //     'email.required' => 'Vui lòng nhập email.',
        //     'email.email' => 'Email không hợp lệ.',
        //     'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn một email khác.',
        //     'email.max' => 'Bạn nhập tên dài quá 50 ký tự',

        //     'phone.required' => 'Vui lòng nhập số điện thoại.',
        //     'phone.min' => 'Số điện thoại phải có 10 chữ số.',
        //     'phone.min' => 'Số điện thoại phải có 10 chữ số.',

        //     'name.required' => 'Vui lòng nhập tên',
        //     'name.max' => 'Bạn nhập tên dài quá 50 ký tự',

        // ]);
        // if (!Auth::check()) {
        //     $request->validate([
        //         'email' => 'unique:users,email',
        //     ], [
        //         'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn một email khác.',
        //     ]);
        // }
        function generateRandomCode($length = 8)
        {
            return strtoupper(substr(md5(uniqid(rand(), true)), 0, $length));
        }
        $cart = session()->get('cart', []);
        $addresses = session()->get('addresses', []);
        $checkOrder = session()->get('checkOrder', []);
        $order = [
            'payment_id' => $request->payment_id,
            'status' => 0,
            'sum_price' => $request->sum_price,
            'address_id' => $request->selected_address,
            'check_payment_id' => 0,
            'order_code' => generateRandomCode(),
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
            Auth::login($user);

            // sửa địa chỉ có user_id null thành id
            $address = Address::where('user_id', NULL)->get();
            foreach ($address as $value) {
                $value->update([
                    'user_id' => $user->id
                ]);
            }
            foreach ($cart as $key => $value) {
                $cart[$key]['user_id'] = $user->id;
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
            ];
            $checkOrder[] = $dataCheck;

            // Phần gửi mail khi không có tài khoản
        } else {
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
            ];
            $checkOrder[] = $dataCheck;
        }

        $emailUser = $request->email;
        $nameUser = $request->name;
        $userSearch = User::where('email', $emailUser)->first();
        foreach ($cart as $key => $value) {
            if ($value['selected_products'] == 1 && $userSearch->id == $value['user_id']) {
                if ($user_id == $value['user_id']) {
                    //  đăng nhập được sản phẩm
                    $value['product_variant_id'] = 0 ? $product_variant_id =  null : $product_variant_id = $value['product_variant_id'];
                    $dataProducts = [
                        'order_id' => $addOrder->id,  // ID đơn hàng
                        'product_id' => $value['product_id'],
                        'product_variant_id' =>  $product_variant_id,
                        'quantity' => $value['qty'],
                        'price' => $request->price
                    ];
                    ProductOder::create($dataProducts);

                    // Nếu sản phẩm có biến thể, kiểm tra và trừ kho
                    $product_variant = ProductVariant::find($product_variant_id);
                    if ($product_variant && $product_variant->stock > 0 && $product_variant->stock - $value['qty'] > 0) {
                        $product_variant->stock -= $value['qty'];
                        $product_variant->save();
                    } else {
                        return redirect()->back()->with([
                            'error'=>'Sản phẩm không đủ số lượng.'
                        ]);
                    }
                } else {
                    $product = Product::find($value['product_id']);
                    if ($product && $product->qty > 0 || $product->qty - $value['qty'] > 0) {
                        $product->qty -= $value['qty'];
                        $product->save();
                    }else {
                        return redirect()->back()->with([
                            'error'=>'Sản phẩm không đủ số lượng.'
                        ]);
                    }

                }
                // làm giảm số giảm giá khi khách đặt hàng
                if ($value['discount_id'] != 0){
                    $discount = Discount::find($value['discount_id']);
                    $discount->update([
                        'qty' => $discount->qty + $value['qty']
                    ]);
                }
                unset($cart[$key]);
            }
        }

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
        } elseif($request->payment_id == 2) {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderInfo = "Thanh toán qua MoMo";
            $amount =  $request->sum_price;
            $orderId = generateRandomCode();
            // $addOrder->order_code
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
        }else{
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/success-checkout";
            $vnp_TmnCode = "RXJT5TCH";//Mã website tại VNPAY
            $vnp_HashSecret = "4TSVTLPJLVR4VUAOAL1F70807XY93Q52"; //Chuỗi bí mật

            $vnp_TxnRef = generateRandomCode(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
            // $addOrder->order_code
            $vnp_OrderInfo = 'Noi dung thanh toán';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->sum_price * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // 127.0.0.1
            $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));
            //Add Params of 2.0.1 Version
            // $vnp_ExpireDate = $_POST['txtexpire'];
            //Billing
            // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
            // $vnp_Bill_Email = $_POST['txt_billing_email'];
            // $fullName = trim($_POST['txt_billing_fullname']);
            // if (isset($fullName) && trim($fullName) != '') {
            //     $name = explode(' ', $fullName);
            //     $vnp_Bill_FirstName = array_shift($name);
            //     $vnp_Bill_LastName = array_pop($name);
            // }
            // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
            // $vnp_Bill_City=$_POST['txt_bill_city'];
            // $vnp_Bill_Country=$_POST['txt_bill_country'];
            // $vnp_Bill_State=$_POST['txt_bill_state'];
            // // Invoice
            // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
            // $vnp_Inv_Email=$_POST['txt_inv_email'];
            // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
            // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
            // $vnp_Inv_Company=$_POST['txt_inv_company'];
            // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
            // $vnp_Inv_Type=$_POST['cbo_inv_type'];
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
                "vnp_ExpireDate"=>$vnp_ExpireDate,
                // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
                // "vnp_Bill_Email"=>$vnp_Bill_Email,
                // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
                // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
                // "vnp_Bill_Address"=>$vnp_Bill_Address,
                // "vnp_Bill_City"=>$vnp_Bill_City,
                // "vnp_Bill_Country"=>$vnp_Bill_Country,
                // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
                // "vnp_Inv_Email"=>$vnp_Inv_Email,
                // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
                // "vnp_Inv_Address"=>$vnp_Inv_Address,
                // "vnp_Inv_Company"=>$vnp_Inv_Company,
                // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
                // "vnp_Inv_Type"=>$vnp_Inv_Type
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            // }

            //var_dump($inputData);
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

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);

                // if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                exit();
                // } else {
                //     echo json_encode($returnData);
                // }
                // vui lòng tham khảo thêm tại code demo
        }

    }
    public function successCheckout()
    {
        $cart = session()->get('cart', []);
        $checkOrder = session()->get('checkOrder', []);
        $order = [];
        $productOrders = [];

        foreach ($checkOrder as $value) {
            $order = Order::with('address', 'payments')->find($value['order_id']);
            $productOrders = ProductOder::with('products', 'product_variants')
                ->where('order_id', $value['order_id'])->get();
            // check xem thanh toán thành công hay thất bại
            if (isset($_GET['resultCode']) && $_GET['resultCode'] != 1006) {
                $order->update([
                    'check_payment_id' => 1,
                ]);
            }
        }

        return view('user.cart.succes-checkout', compact('cart', 'checkOrder', 'order', 'productOrders'));
    }

}
