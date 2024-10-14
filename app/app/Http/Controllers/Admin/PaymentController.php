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

    public function updatePayment(Request $request)
    {
        $users = User::all();
        $payment = Payment::where('id', $request->id)->first();
        return view('admin.payment.update', compact('payment','users'));
    }
    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'submit');

        dd($data); 
        Payment::where('id', $request->id)->update($data);
        return redirect()->route('admin.formPayment')->with('message', 'Cập nhật dữ liệu thành công');
    }

    public function destroy(Request $request)
    {
        $discount = Payment::find($request->id);
        $discount->delete();
        return redirect()->route('admin.formPayment')->with('message', 'Xóa dữ liệu thành công');
    }
}
