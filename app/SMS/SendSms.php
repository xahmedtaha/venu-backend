<?php

namespace App\SMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\SMS\Orange;


trait SendSms
{
    public static function sendVerificationSMS($to, $pincode)
    {
        $senderName = 'Venu App';
        if(str_starts_with($to,'010')||str_starts_with($to,'2010')||str_starts_with($to,'+2010')||str_starts_with($to,'20010'))
            $senderName = 'Venu App EG';
        $message = Lang::get('auth.verification_message',['pincode'=>$pincode]);
//        $url = "https://smssmartegypt.com/sms/api?username=Videnetworks@gmail.com&password=vIdenEtworks20&sendername=Venu App&mobiles={$to}&message={$message}";
//        Orange::sendSms($to,$message);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://smssmartegypt.com/sms/api/json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                                    "username": "Videnetworks@gmail.com",
                                    "password": "vIdenEtworks20",
                                    "sendername": "'.$senderName.'",
                                    "mobiles": "'.$to.'",
                                    "message": "'.$message.'"
                                }',
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: en-US',
                'Accept: application/json',
                'Content-Type: application/json',
                'Cookie: __cfduid=def8bbe3a18d43d0f1d91de5b3c88d9281620610029'
            ),
        ));

        $response = curl_exec($curl);
//        dd($response);
        curl_close($curl);
//         $response;
//        file_get_contents($url);
    }
}
