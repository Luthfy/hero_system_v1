<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelMember extends Model
{
    protected $primaryKey = 'id';

    public $fillable = [
        "name_level_member",
        "poin_level_member",
        "bonus_sponsor",
        "description_level_member"
    ];
}
