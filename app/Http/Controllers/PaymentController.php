<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Transaction;
use App\Subscription;
use App\Traits\MobilpayTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentDetails($model)
    {
        $paymentDetails = '';
        if (get_class($model) == "App\Subscription"){
            $type = $model->type == 3 ? 'year' : ($model->type == 2 ? 'month' : 'week');

            $paymentDetails = 'A '. $model->multiple .' '. str_plural($type, $model->multiple) .' subscription by Dr. '. $model->user->name .'. Amount: '. setting('currency') . $model->amount .'.';
        }

        if (get_class($model) == "App\Transaction"){
            $paymentDetails = 'An appointment fee payment by '. $model->user->name .' to Dr. '. $model->doctor->name .'. Amount: '. setting('currency') . $model->amount .'.';
        }

        return $paymentDetails;   
    }



    /** ~~ MobilPay Payment Processing.. ~~ */
    

    /**
     * Process a payment request.
     *
     * @return ...
     */
    public function mobilpayRequestRedirect()
    {
        $tId    = \Route::current()->model;
        $model = starts_with($tId, 'SUB') 
                    ? \App\Subscription::where('transaction_id', $tId)->first()
                    : \App\Transaction::where('transaction_id', $tId)->first()
                    ;
        $details = $this->paymentDetails($model);

        return view('mobilpay.cardRedirect', compact('model','details'));
    }

    public function mobilpayConfirm()
    {

        return view('mobilpay.cardConfirm');

    }

    public function mobilpayReturn()
    {

        return view('mobilpay.cardReturn');

    }
}
