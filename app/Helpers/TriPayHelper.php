<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class TriPayHelper
{

    private $api_key = "ad8gJo5r0i0dUjTj6wNkgUfcHXQGwT47";
    private $web_url = "https://tripay.co.id/api/v2/";
    private $headers = array();

    public function __construct()
    {
        $this->headers = array(
            'Accept: application/json',
            'Authorization: Bearer' . $this->api_key
        );
    }

    public function tripay_produk_pembelian()
    {
        return Http::post($this->web_url . 'pembelian/categpry');
    }

    public function handleCallback(Request $request)
    {
        $incomingSecret = $request->server('HTTP_X_CALLBACK_SECRET') ?? '';

        if (! hash_equals($this->api_key, $incomingSecret))
        {
            Log::error('Invalid secret : ' . $this->api_key . " vs " . $incomingSecret);
            return;
        }

        $json = $request->all();

        Log::info('callback tripay : ' . $json);

        return $json;
    }


}
