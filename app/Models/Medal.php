<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medal extends Model
{

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d H:i:s'
    ];

    protected $fillable = ["name_medal", "reward_medal", "max_penarikan", "min_saldo", "persyaratan_medal"];
}
