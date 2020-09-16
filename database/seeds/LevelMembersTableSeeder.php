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
            'uuid_level_member'         => Uuid::uuid4()->getHex()->toString(),
            'name_level_member'         => 'Downloader Free',
            'description_level_member'  => ''
        ]);

        LevelMember::create([
            'uuid_level_member'         => Uuid::uuid4()->getHex()->toString(),
            'name_level_member'         => 'Reseller Free',
            'description_level_member'  => 'Memiliki Upline'
        ]);

        LevelMember::create([
            'uuid_level_member'         => Uuid::uuid4()->getHex()->toString(),
            'name_level_member'         => 'Ekonomi Member',
            'description_level_member'  => 'Top Up 350.000 Poin'
        ]);

        LevelMember::create([
            'uuid_level_member'         => Uuid::uuid4()->getHex()->toString(),
            'name_level_member'         => 'Bisnis Member',
            'description_level_member'  => 'Top Up 3.500.000 Poin'
        ]);

        LevelMember::create([
            'uuid_level_member'         => Uuid::uuid4()->getHex()->toString(),
            'name_level_member'         => 'Eksekutif Member',
            'description_level_member'  => 'Top Up 35.000.000 Poin'
        ]);
    }
}
