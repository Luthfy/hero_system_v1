<?php

namespace App\Http\Controllers\PPOB;

use Illuminate\Http\Request;
use App\Helpers\TriPayHelper;
use App\Http\Controllers\Controller;

class PembelianCustomerController extends Controller
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

    public function transaksi_pembelian($data)
    {
        $data_tripay = array();

        if ($data['type'] == 'PLN')
        {
            $data_tripay = [
                'inquiry'       => 'PLN',
                'code'          => $data['kode_produk'],
                'phone'         => $data['no_hp'],
                'no_meter_pln'  => $data['no_pln'],
                'api_trxid'     => "INVPLN" . time()
            ];
        }
        else
        {
            $data_tripay = [
                'inquiry'       => 'I',
                'code'          => $data['kode_produk'],
                'phone'         => $data['no_hp'],
                'no_meter_pln'  => $data['no_pln'],
                'api_trxid'     => 'INV'
            ];
        }
        // $d_tripay = array();
        // $data_tripay = array(
        //     'inquiry'   => $data['type'] == 'PLN' ? 'PLN' : 'I', // 'PLN' untuk pembelian PLN Prabayar, atau 'I' (i besar) untuk produk lainnya
        //     'code'      => $data['produk'], // kode produk
        //     'phone'         => $data['phone'], // nohp pembeli
        //     'no_meter_pln' => '1234567890', // khusus untuk pembelian token PLN prabayar
        //     'api_trxid' => 'INV757', // ID transaksi dari server Anda. (tidak wajib, maks. 25 karakter)
        //     'pin' => '3964', // pin member
        // );
    }
}
