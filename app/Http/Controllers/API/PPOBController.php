<?php

namespace App\Http\Controllers\API;

use App\Helpers\TriPayHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PPOB\PembayaranController;
use App\Http\Controllers\PPOB\PembelianController;
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

    public function pembayaran_kategori()
    {
        $pembayaran = new PembayaranController();
        return $pembayaran->kategori_pembayaran();
    }

    public function pembayaran_operator()
    {
        $pembayaran = new PembayaranController();
        return $pembayaran->operator_pembayaran();
    }

    public function pembayaran_produk()
    {
        $pembayaran = new PembayaranController();
        return $pembayaran->produk_pembayaran();
    }

    public function pembayaran_detail(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $pembayaran = new PembayaranController();
        return $pembayaran = $pembayaran->detail_pembayaran($request->code);
    }

    public function pembelian_kategori()
    {
        $pembayaran = new PembelianController();
        return $pembayaran->kategori_pembelian();
    }

    public function pembelian_operator()
    {
        $pembayaran = new PembelianController();
        return $pembayaran->operator_pembelian();
    }

    public function pembelian_produk()
    {
        $pembayaran = new PembelianController();
        return $pembayaran->produk_pembelian();
    }

    public function pembelian_detail(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $pembayaran = new PembelianController();
        return $pembayaran = $pembayaran->detail_pembelian($request->code);
    }

}
