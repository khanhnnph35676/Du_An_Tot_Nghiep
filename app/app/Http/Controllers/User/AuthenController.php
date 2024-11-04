<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;

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

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->rule_id == 1){
                return redirect()->intended('admin');
            }
            if(Auth::user()->rule_id == 2){
                return redirect()->intended('');
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
                'rule_id' => 1,
            ]);

            // Gửi sự kiện đăng ký
            event(new Registered($user));

            // Đăng nhập người dùng ngay sau khi đăng ký
            Auth::login($user);

            return redirect()->intended('admin')->with('status', 'Đăng ký thành công.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại.']);
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
    public function registerHome()
    {
        return view('user.register');
    }
    public function forgotPassword()
    {
        return view('user.forgot-password');
    }
}
