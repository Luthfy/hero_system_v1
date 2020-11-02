<?php

namespace App\Http\Controllers\PPOB;

use App\Helpers\TriPayHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    private $_client = null;

    public function __construct()
    {
        $this->_client = new TriPayHelper();
    }

    public function kategori_pembayaran()
    {
        $activity = "get kategori pembayaran dari tripay";

        $request = $this->_client->tripay_post('pembayaran/category/');

        return $request;
    }

    public function operator_pembayaran()
    {
        $activity = "get operator pembayaran dari tripay";

        $request = $this->_client->tripay_post('pembayaran/operator/');

        return $request;
    }

    public function produk_pembayaran()
    {
        $activity = "get produk pembayaran dari tripay";

        $request = $this->_client->tripay_post('pembayaran/produk/');

        return $request;
    }

    public function detail_pembayaran($code)
    {
        $activity = "get produk pembayaran dari tripay";

        $data = [
            'code' => $code
        ];

        $request = $this->_client->tripay_post('pembayaran/produk/cek', $data);

        return $request;
    }
}
