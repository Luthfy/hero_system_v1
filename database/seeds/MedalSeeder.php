<?php

use App\Models\Medal;
use Illuminate\Database\Seeder;

class MedalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Medal::create([
            'name_medal' => 'Ruby',
            'reward_medal' => 2,
            'max_penarikan' => 1000000,
            'min_saldo' => 2000000,
            'persyaratan_medal' => '16 Reseller Free <br />4 Ekonomi'
        ]);

        Medal::create([
            'name_medal' => 'Sapphire',
            'reward_medal' => 2,
            'max_penarikan' => 5000000,
            'min_saldo' => 2000000,
            'persyaratan_medal' => '16 Reseller Free <br />4 Ekonomi <br />4 Ruby'
        ]);

        Medal::create([
            'name_medal' => 'Emerald',
            'reward_medal' => 2,
            'max_penarikan' => 35000000,
            'min_saldo' => 2000000,
            'persyaratan_medal' => '16 Reseller Free <br />4 Ekonomi <br />4 Ruby<br />4 Sapphire'
        ]);

        Medal::create([
            'name_medal' => 'Diamond',
            'reward_medal' => 2,
            'max_penarikan' => 150000000,
            'min_saldo' => 2000000,
            'persyaratan_medal' => '16 Reseller Free <br />4 Ekonomi <br />4 Ruby<br />4 Sapphire<br />4 Emerald'
        ]);

        Medal::create([
            'name_medal' => 'Crown',
            'reward_medal' => 1,
            'max_penarikan' => 500000000,
            'min_saldo' => 2000000,
            'persyaratan_medal' => '16 Reseller Free <br />4 Ekonomi <br />4 Ruby<br />4 Sapphire<br />4 Emerald<br />4 Diamond'
        ]);

        Medal::create([
            'name_medal' => 'Ambasador',
            'reward_medal' => 1,
            'max_penarikan' => 1000000000,
            'min_saldo' => 2000000,
            'persyaratan_medal' => '16 Reseller Free <br />4 Ekonomi <br />4 Ruby<br />4 Sapphire<br />4 Emerald<br />4 Diamond<br />4 crown'
        ]);
    }
}
