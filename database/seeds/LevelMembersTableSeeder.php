<?php

use Illuminate\Database\Seeder;
use App\Models\LevelMember;
use Ramsey\Uuid\Uuid;

class LevelMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LevelMember::create([
            'name_level_member'         => 'Downloader Free',
            'poin_level_member'         => 0,
            'bonus_sponsor'             => 0,
            'description_level_member'  => ''
        ]);

        LevelMember::create([
            'name_level_member'         => 'Reseller Free',
            'poin_level_member'         => 0,
            'bonus_sponsor'             => 0,
            'description_level_member'  => 'Memiliki Upline'
        ]);

        LevelMember::create([
            'name_level_member'         => 'Ekonomi Member',
            'poin_level_member'         => 350000,
            'bonus_sponsor'             => 30,
            'description_level_member'  => 'Top Up 350.000 Poin'
        ]);

        LevelMember::create([
            'name_level_member'         => 'Bisnis Member',
            'poin_level_member'         => 3500000,
            'bonus_sponsor'             => 40,
            'description_level_member'  => 'Top Up 3.500.000 Poin'
        ]);

        LevelMember::create([
            'name_level_member'         => 'Eksekutif Member',
            'poin_level_member'         => 35000000,
            'bonus_sponsor'             => 50,
            'description_level_member'  => 'Top Up 35.000.000 Poin'
        ]);
    }
}
