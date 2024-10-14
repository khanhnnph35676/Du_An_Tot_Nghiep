<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function formPayment(){
        $payments = Payment::all();
        return view('admin.payment.form', compact('payments'));
    }

    public function createPayment(){
        $users = User::all();
        $payments = Payment::all();
        return view('admin.payment.create',compact('users', 'payments'));
    }

    public function storePayment(Request $request)
    {
        $data = $request->all();
        // dd($data);

        Payment::query()->create($data);
        return redirect()->route('admin.formPayment')->with('message', 'Thêm dữ liệu thành công');
    }
}
