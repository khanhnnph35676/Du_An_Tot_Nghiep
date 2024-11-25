<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\ProductOder;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use App\Models\Address;

class AuthenController extends Controller
{
    public function logout(Request $request)
{
    Auth::logout(); // Đăng xuất người dùng

    return redirect()->route('loginAdmin')->with('status', 'Bạn đã đăng xuất thành công.');
}

    public function loginAdmin()
    {
        return view('admin.login');
    }

    public function postLoginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->rule_id == 1){
                return redirect()->intended('admin');
            }
            if(Auth::user()->rule_id == 2){
                return redirect()->back()->with([
                    'message' => 'Tài khoản không tồn tài'
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registerAdmin()
    {
        return view('admin.register');
    }

    public function postRegister(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        try {
            // Tạo người dùng mới
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rule_id' => 1, // giá trị mặc định hoặc có thể được cấu hình
            ]);

            event(new Registered($user));

            // Đăng nhập người dùng ngay sau khi đăng ký
            Auth::login($user);

            return redirect()->intended('admin')->with('status', 'Đăng ký thành công.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại. Chi tiết lỗi: ' . $e->getMessage()]);
        }
    }



    public function showLinkRequestForm()
    {
        return view('admin.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
            Auth::login($user); // Đăng nhập ngay sau khi đặt lại mật khẩu
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('admin')->with('status', trans($response));
        }

        return back()->withErrors(['email' => trans($response)]);
    }

    public function loginHome()
    {
        return view('user.login');
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->rule_id == 2){
                return redirect()->intended('');
            }
            if(Auth::user()->rule_id == 1){
                return redirect()->back()->with([
                    'message' => 'Tài khoản không tồn tài'
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function registerHome()
    {
        return view('user.register');
    }
    public function forgotPassword()
    {
        return view('user.forgot-password');
    }
    public function logoutUser(Request $request)
    {
        Auth::logout();
        return redirect()->back();
    }
    // xoá địa chỉ
    public function destroy($id)
    {
        try {
            // Tìm và xóa địa chỉ trong database
            $address = Address::findOrFail($id);
            $address->delete();

            return response()->json(['success' => true, 'message' => 'Địa chỉ đã được xóa']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Xóa địa chỉ thất bại']);
        }
    }
    //Thêm địa chỉ mới
    public function store(Request $request)
    {
        // dd($request->all());
        Address::create([
            'address' => $request->province . ', ' . $request->district . ', ' . $request->ward,
            'home_address' => $request->home_address,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->back()->with([
            'message' => 'Thêm địa chỉ thành công'
        ]);
    }

    public function AddOrder(Request $request)
    {
        $request->validate([
            'sum_price' => 'required|min:1',  // Kiểm tra giá trị là số và lớn hơn 0
            'address_id' => 'required|exists:addresses,id',  // Kiểm tra address_id có tồn tại trong bảng addresses
            'email' => 'required|email',  // Kiểm tra email hợp lệ
            'phone' => 'required|min:10',  // Kiểm tra phone là số và có ít nhất 10 chữ số
            'payment_id' => 'required',  // Kiểm tra payment_id có giá trị hợp lệ (ví dụ COD, credit_card, bank_transfer)
        ], [
            // Các thông báo lỗi tùy chỉnh (nếu cần thiết)
            'sum_price.required' => 'Giá trị tổng phải được nhập.',
            'sum_price.min' => 'Giá trị tổng phải lớn hơn 0.',
            'address_id.exists' => 'Địa chỉ không tồn tại.',
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Số điện thoại không được bỏ trống.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
            'payment_id.required' => 'Phương thức thanh toán phải được chọn.',
        ]);
        function generateRandomCode($length = 8) {
            return strtoupper(substr(md5(uniqid(rand(), true)), 0, $length));
        }

        $order = [
            'payment_id' => 1,
            'status' => 1,
            'sum_price' => $request->sum_price,
            'address_id' => $request->selected_address,
            'order_code'=> generateRandomCode(),
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
            if( Auth::user()->id == $value['user_id'] ) {
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
        return redirect()->route('storeHome')->with([
            'success' => 'Chúc mừng thanh toán thành công'
        ]);
    }
}
