<?php
namespace App;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => 'administrator',
            "email" => 'administrator@hero-indonesia.com',
            "password" => Hash::make($value)
        ]);
    }
}
