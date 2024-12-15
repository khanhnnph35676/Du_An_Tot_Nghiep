<?php

namespace App\Http\Controllers\User;
use App\Models\Rule;
use App\Models\User; // Model người dùng
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;



use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register()
    {
        return view('user.register');
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
                'rule_id' => 2, // Rule dành cho người dùng thường
            ]);

            event(new Registered($user));

            // Đăng nhập người dùng ngay sau khi đăng ký
            Auth::login($user);

            return redirect()->intended('')->with('status', 'Đăng ký thành công.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại. Chi tiết lỗi: ' . $e->getMessage()]);
        }
    }

    // Hiển thị form đổi mật khẩu
    public function changePassword()
    {
        $cart = session()->get('cart', []);
        return view('user.change-password',compact('cart'));
    }

    // Xử lý yêu cầu đổi mật khẩu
//     public function updatePassword(Request $request)
// {
//     // Validate input
//     $request->validate([
//         'current_password' => 'required|string',
//         'new_password' => 'required|string|min:8|confirmed',
//     ]);

//     $user = Auth::user();


//     if (!Hash::check($request->current_password, $user->password)) {
//         return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
//     }

//     try {
      
//         $user->password = Hash::make($request->new_password);

      
//         if ($user->save()) {
//             return redirect()->route('')->with('status', 'Đổi mật khẩu thành công.');
//         } else {
//             return back()->withErrors(['error' => 'Không thể lưu mật khẩu mới.']);
//         }
//     } catch (\Exception $e) {
//         return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
//     }
// }

}