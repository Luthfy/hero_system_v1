<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medal extends Model
{
    protected $fillable = ["name_medal", "reward_medal", "max_penarikan", "min_saldo", "persyaratan_medal"];
}
