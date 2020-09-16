<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TriPayHelper
{
    private $api_key = "3b5c5854aae73361400751e81b454e262720e8ade1108a72";
    private $web_url = "https://tripay.co.id/api/v2/";
    private $headers = array();

    public function __construct()
    {
        $this->headers = array(
            'Accept: application/json',
            'Authorization: Bearer' . $this->api_key
        );
    }

    public function tripay_product()
    {

    }


}
