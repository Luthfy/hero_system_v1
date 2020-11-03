<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class TriPayHelper
{
    /**
     * Status Code PPOB :
     * 0 = gagal sebelum dilakukan transaksi
     * 1 = sedang dalam antrian
     * 2 = sukses melakukan transaksi
     * 3 = gagal dalam proses transaksi
     * 4 = dibatalkan karena suatu alasan
    */

    /**
     * User Type :
     * 0 = From Back Office
     * 1 = Mobile Customer
     * 2 = Mobile Driver
     * 3 = Mobile Merchant
    */


    private $api_key = "XzfMJLuGjWELYkvLcg80Rc1e7NFhxufb";
    private $web_url = "https://tripay.co.id/api/v2/";
    private $pin     = "8571";
    private $headers = array();

    public function __construct()
    {
        $this->headers = array(
            'Accept' => 'application/json',
            'Authorization'=> 'Bearer ' . $this->api_key
        );
    }

    public function server_connection()
    {
        $activity = "testing server connection tripay";

        $cekserver = Http::withHeaders($this->headers)->post($this->web_url . 'cekserver/');
        return $cekserver->json();
    }

    public function check_balance()
    {
        $activity = "testing server connection tripay";

        $balance = Http::withHeaders($this->headers)->post($this->web_url . 'ceksaldo/');
        return $balance->json();
    }

    public function tripay_post($url, $data = null)
    {
        $activity = "melakukan request ke tripay";

        if ($data == null)
        {
            $request = Http::withHeaders($this->headers)->post($this->web_url . $url);
            return $request->json();
        }
        else
        {
            $request = Http::withHeaders($this->headers)->post($this->web_url . $url, $data);
            return $request->json();
        }
    }

    public function pembelian_prabayar($data)
    {
        $activity = "testing server connection tripay";

        if ($data['inquiry'] == 'PLN')
        {
            $data = [
                'inquiry'       => $data['inquiry'],
                'code'          => $data['kode_produk'],
                'phone'         => $data['no_hp'],
                'no_meter_pln'  => $data['no_pln'],
                'api_trxid'     => "INVPLN" . time(),
                'pin'           => $this->pin
            ];

            return Http::withHeaders($this->headers)
                        ->post($this->web_url . 'transaksi/pembelian', $data)
                        ->json();
        }
        else
        {
            $data = [
                'inquiry'       => $data['inquiry'],
                'code'          => $data['kode_produk'],
                'phone'         => $data['no_hp'],
                'no_meter_pln'  => $data['no_pln'],
                'api_trxid'     => '',
                'pin'           => $this->pin
            ];

            return Http::withHeaders($this->headers)
                        ->post($this->web_url . 'transaksi/pembelian', $data)
                        ->json();
        }

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
