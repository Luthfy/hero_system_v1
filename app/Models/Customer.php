<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'uuid_customer';

    public $incrementing = false;

    protected $hidden = [
        'password_customer', 'id',
    ];

    protected $casts = [
        'created_at' => 'date:y-m-d',
        'updated_at' => 'date:y-m-d h:i:s'
    ];
}
