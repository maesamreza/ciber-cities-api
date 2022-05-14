<?php

namespace App\Http\Controllers;

use App\Models\OrderPayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        

        // Stripe\Charge::create ([
        //         "amount" => 100 * 100,
        //         "currency" => "usd",
        //         "source" => $request->stripeToken,
        //         "description" => "Test payment from itsolutionstuff.com." 
        // ]);
        return response()->json(['Successfull'=>'Payment successful!'],200);
    }
}
