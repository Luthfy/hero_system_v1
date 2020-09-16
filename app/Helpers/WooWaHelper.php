<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WooWaHelper
{

    private $api_key = "3b5c5854aae73361400751e81b454e262720e8ade1108a72";
    private $web_url = "http://116.203.92.59/api/";

    public function sendWaMessage($receiver, $message)
    {

        $data = [
            "phone_no" => $receiver,
            "key" => $this->api_key,
            "message" => $message
        ];

        $response = Http::post($this->web_url . "send_message", $data);

        return $response;

    }

    public function checkWaAvailable($receiver)
    {
        $data = [
            "phone_no" => $receiver,
            "key" => $this->api_key
        ];

        $response = Http::post($this->web_url . "check_number", $data);

        return $response;

    }

}
