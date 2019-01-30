<?php

namespace App\Traits;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait MobilpayTrait
{
    /**
     * Process a payment request.
     *
     * @return ...
     */
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

    public function paymentRequest($model, User $user)
    {
        $paymentDetails = $this->paymentDetails($model);

        // dd(
        //     // 'model type= '. ($model),
        //     'key= '. env('MOBILPAY_SIGNATURE'),
        //     'token_id= '. env('MOBILPAY_TOKEN_ID'),
        //     'id= '. $model->transaction_id, 
        //     'timestamp= '. Carbon::parse(Carbon::now())->format('YmdHis'), 
        //     'amount= '. $model->amount,
        //     'customer_id= '. $user->id,
        //     'pan_masked= '. $user->last_four,
        //     '                                 ',
        //     '******* Payment Details *********',
        //     '*********************************',
        //     'first_name= '. $user->firstName,
        //     'last_name= '. $user->lastName,
        //     'email= '. $user->email,
        //     'address= '. $user->address,
        //     'mobile_phone= '. $user->phone,
        //     'details= '. $paymentDetails
        // );

        $url = "http://sandboxsecure.mobilpay.ro/card3";
        /* <?xml version="1.0" encoding="utf-8"?> */
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <order 
            type="card" 
            id="'. $model->transaction_id .'" 
            timestamp="'. Carbon::parse(Carbon::now())->format('YmdHis') .'"> 

            <signature>'. env('MOBILPAY_SIGNATURE') .'</signature> 

            <invoice 
                currency="RON" 
                amount="'. $model->amount .'" 
                installments="R1,R2" 
                selected_installments="R2" 
                customer_type="2" 
                customer_id="'. $user->id .'" 
                token_id="'. env('MOBILPAY_TOKEN_ID') .'" 
                pan_masked="'. $user->last_four .'" 
                > 

                <details>'. $paymentDetails .'</details> 

                <contact_info> 
                    <billing type="person"> 
                        <first_name>'. $user->firstName .'</first_name> 
                        <last_name>'. $user->lastName .'</last_name> 
                        <email>'. $user->email .'</email> 
                        <address>'. $user->address .'</address> 
                        <mobile_phone>'. $user->phone .'</mobile_phone> 
                    </billing> 
                </contact_info> 
            </invoice>

            <params> 
                <param> 
                    <name>param1Name</name> 
                    <value>param1Value</value> 
                </param> 
            </params> 

            <url> 
                <confirm>http://medapp.demo/confirm</confirm>
                <return>http://medapp.demo/return</return> 
            </url> 
        </order>';

        // $headers = array(
        //   "Content-type: text/xml",
        //   "Content-length: " . strlen($xml),
        //   "Connection: close",
        // );

        //setting the curl parameters.
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // $data = curl_exec($ch);
        // dd($data);

        // curl_errno($ch) ? print curl_error($ch) : curl_close($ch);


 
        $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_MUTE, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = curl_exec($ch);
        dd($data);

        curl_close($ch);



        // //convert the XML result into array
        // $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

        // // dd($array_data);

        // print_r('<pre>');
        // print_r($array_data);
        // print_r('</pre>');
    }


    /**
     * Process a payment request.
     *
     * @return ...
     */
    public function paymentResponse(Request $request, User $user)
    {
        //
        <?xml version="1.0" encoding="utf-8"?> 
        <order 
            type="card" 
            id="string64" 
            timestamp="YYYYMMDDHHMMSS"> {your_request_XML} 
            <mobilpay timestamp="YYYYMMDDHHMMSS" crc="XXXXX"> 
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
        </order>

    }
}