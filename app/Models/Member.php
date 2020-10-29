<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $primaryKey = 'uuid_member';

    public $incrementing = false;

    protected $casts = [
        'created_at' => 'date:yy-m-d h:i:s',
        'updated_at' => 'date:yy-m-d h:i:s',
    ];
}
