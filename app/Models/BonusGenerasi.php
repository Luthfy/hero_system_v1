<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusGenerasi extends Model
{
    protected $table = 'bonus_generasi';

    protected $fillable = ["level_generasi", "bonus_persen"];
}
