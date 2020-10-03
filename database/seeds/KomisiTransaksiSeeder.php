<?php

use App\Models\KomisiTransaksi;
use Illuminate\Database\Seeder;

class KomisiTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KomisiTransaksi::create([
            "jenis_transaksi" => "Komisi Perusahaan",
            "besaran_komisi" => 30
        ]);

        KomisiTransaksi::create([
            "jenis_transaksi" => "Komisi Manager",
            "besaran_komisi" => 10
        ]);

        KomisiTransaksi::create([
            "jenis_transaksi" => "Komisi Director",
            "besaran_komisi" => 10
        ]);

        KomisiTransaksi::create([
            "jenis_transaksi" => "Komisi Mitra / Vendor",
            "besaran_komisi" => 10
        ]);

        KomisiTransaksi::create([
            "jenis_transaksi" => "Komisi Profit Share",
            "besaran_komisi" => 10
        ]);
    }
}
