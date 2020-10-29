<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{

    protected $fillable = ["uuid_affiliate", "uuid_member", "uuid_member_child"];

    protected $casts = [
        'created_at' => 'date:y-m-d',
        'updated_at' => 'date:y-m-d h:i:s'
    ];
}
