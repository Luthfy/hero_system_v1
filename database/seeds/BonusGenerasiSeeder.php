<?php

use App\Models\BonusGenerasi;
use Illuminate\Database\Seeder;

class BonusGenerasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BonusGenerasi::create([
            "level_generasi" => "Level 2",
            "bonus_persen" => 3
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 3",
            "bonus_persen" => 2
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 4",
            "bonus_persen" => 1.5
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 5",
            "bonus_persen" => 1
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 6",
            "bonus_persen" => 0.5
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 7",
            "bonus_persen" => 0.5
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 8",
            "bonus_persen" => 0.5
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 9",
            "bonus_persen" => 0.5
        ]);

        BonusGenerasi::create([
            "level_generasi" => "Level 10",
            "bonus_persen" => 0.5
        ]);
    }
}
