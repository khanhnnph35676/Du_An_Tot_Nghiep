<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        return view('user.order-history'); // Đảm bảo đường dẫn đúng với file bạn đã tạo
    }
}
