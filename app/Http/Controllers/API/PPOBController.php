<?php

namespace App\Http\Controllers\API;

use App\Helpers\TriPayHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PPOBController extends Controller
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

    /**
     * test connection
     * digunakan untuk melakukan testing pada server
     * tidak di implementasikan pada client
     *
     * @return void
     */
    public function test_connection()
    {
        $tripay = new TriPayHelper();
        return $tripay->server_connection();
    }
}
