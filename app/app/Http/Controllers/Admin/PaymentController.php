<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function formPayment(){
        $payments = Payment::all();
        return view('admin.payment.form', compact('payments'));
    }

    public function createPayment(){
        return view('admin.payment.create');
    }
}
