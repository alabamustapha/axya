<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use App\Subscription;
use App\Traits\MobilpayTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use MobilpayTrait;

    /**
     * Process a payment response.
     *
     * @return ...
     */
    public function paymentResponse()
    {
        $url = "http://sandboxsecure.mobilpay.ro/card3";
        
        /*
            $xml = '<?xml version="1.0" encoding="utf-8"?> 
            <order 
                type="card" 
                id="string64" 
                timestamp="YYYYMMDDHHMMSS"> {your_request_XML} 
                <mobilpay 
                    timestamp="YYYYMMDDHHMMSS" 
                    crc="XXXXX"> 
                    <action>action_type</action> 
                    <customer type="person|company"> 
                        <first_name>first_name</first_name> 
                        <last_name>last_name</last_name> 
                        <address>address</address> 
                        <email>email_address</email> 
                        <mobile_phone>phone_no</mobile_phone> 
                    </customer> 

                    <purchase>mobilPay_purchase_no</purchase> 
                    <original_amount>XX.XX</original_amount> 
                    <processed_amount>NN.NN</processed_amount> 
                    <pan_masked>X****YYYY</pan_masked> 
                    <payment_instrument_id>ZZZZZZZ</payment_instrument_id> 
                    <token_id>token_identifier</token_id> 
                    <token_expiration_date>YYYY-MM-DD HH:MM:SS</token_expiration_date> 
                    <error code="N">error_message</error> 
                </mobilpay> 
            </order>';
        */
 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        dd($data);

        curl_close($ch);

        //convert the XML result into array
        $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

        dd($array_data);

    }


    public function paymentDetails($model)
    {
        $paymentDetails = '';
        if (get_class($model) == "App\Subscription"){
            $type = $model->type == 3 ? 'year' : ($model->type == 2 ? 'month' : 'week');

            $paymentDetails = 'A '. $model->multiple .' '. str_plural($type, $model->multiple) .' subscription by Dr. '. $model->user->name .'. Amount: '. env('currency') . $model->amount .'.';
        }
        if (get_class($model) == "App\Transaction"){
            $paymentDetails = 'An appointment fee payment by '. $model->user->name .' for to Dr. '. $model->doctor->name;
        }

        return $paymentDetails;   
    }
}
