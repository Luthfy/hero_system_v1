<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{

    use HasApiTokens, Notifiable;

    protected $primaryKey = 'uuid_driver';

    public $incrementing = false;

    protected $hidden = [
        'password_driver', 'id',
    ];

    protected $casts = [
        'created_at' => 'date:y-m-d',
        'updated_at' => 'date:y-m-d h:i:s'
    ];

}
