<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Merchant extends Authenticatable
{

    use HasApiTokens, Notifiable;

    protected $primaryKey = 'uuid_merchant';

    public $incrementing = false;

    protected $hidden = [
        'password_merchant', 'id',
    ];

    protected $casts = [
        'created_at' => 'date:y-m-d',
        'updated_at' => 'date:y-m-d h:i:s'
    ];

}
