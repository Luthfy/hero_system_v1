<?php

use App\Models\BatasanPenarikan;
use Illuminate\Database\Seeder;

class BatasanPenarikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BatasanPenarikan::create(
            [
                "jenis_batasan" => "Reseller",
                "besaran_batasan" => 100000,
                "estimasi_waktu_batasan" => "1 hari"
            ]
        );

        BatasanPenarikan::create(
            [
                "jenis_batasan" => "Ekonomi",
                "besaran_batasan" => 350000,
                "estimasi_waktu_batasan" => "1 hari"
            ]
        );

        BatasanPenarikan::create(
            [
                "jenis_batasan" => "Bisnis",
                "besaran_batasan" => 3500000,
                "estimasi_waktu_batasan" => "1 hari"
            ]
        );

        BatasanPenarikan::create(
            [
                "jenis_batasan" => "Eksekutif",
                "besaran_batasan" => 0,
                "estimasi_waktu_batasan" => "1 hari"
            ]
        );
    }
}
