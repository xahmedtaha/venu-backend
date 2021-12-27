<?php


namespace App\SMS;


use App\Models\SiteConfig;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Orange
{
    const CONFIG_KEY = "ORANGE_ACCESS_TOKEN";
    public static function sendSms($phoneNumber,$message)
    {
        $devPhoneNumber = "2001222112984";
        $accessToken = SiteConfig::getValue(self::CONFIG_KEY);
        $curl = curl_init();

        $body = [
            "outboundSMSMessageRequest"=> [
                "address" => "tel:+2$phoneNumber",
                "senderAddress" =>"tel:+$devPhoneNumber",
                "senderName"=>"Venu",
                "outboundSMSTextMessage" => [
                    "message" => $message
                ]
            ]
        ];
//        dd("Authorization: Bearer $accessToken");
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B$devPhoneNumber/requests",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

//        dd(json_decode($response));
    }

    public static function refreshToken()
    {
        $config = SiteConfig::get(self::CONFIG_KEY);
        if(!$config)
        {
            self::saveToken();
        }
        else
        {
            $days = Carbon::now()->diffInDays($config->updated_at);
            if($days>89)
            {
                self::saveToken();
            }
        }
    }

    public static function getToken()
    {
        $authorizationHeader = env('ORANGE_AUTHORIZATION_HEADER');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.orange.com/oauth/v2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Basic $authorizationHeader"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        $token = $response->access_token;
        return $token;
    }

    public static function saveToken(): void
    {
        $token = self::getToken();
        SiteConfig::set(self::CONFIG_KEY,$token);
    }

}
