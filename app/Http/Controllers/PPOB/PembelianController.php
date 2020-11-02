<?php

namespace App\Http\Controllers\PPOB;

use Illuminate\Http\Request;
use App\Helpers\TriPayHelper;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    private $_client = null;

    public function __construct()
    {
        $this->_client = new TriPayHelper();
    }

    public function kategori_pembelian()
    {
        $activity = "get kategori pembelian dari tripay";

        $request = $this->_client->tripay_post('pembelian/category/');
        return $request;
    }

    public function operator_pembelian()
    {
        $activity = "get operator pembelian dari tripay";

        $request = $this->_client->tripay_post('pembelian/operator/');
        return $request;
    }

    public function produk_pembelian()
    {
        $activity = "get produk pembelian dari tripay";

        $request = $this->_client->tripay_post('pembelian/produk/');
        return $request;
    }

    public function detail_pembelian($code)
    {
        $activity = "get detail pembelian dari tripay";

        $data = [
            'code' => $code
        ];

        $request = $this->_client->tripay_post('pembelian/produk/cek', $data);
        return $request;
    }
}
