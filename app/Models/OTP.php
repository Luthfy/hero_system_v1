<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = "otp_clients";

    protected $fillable = ["uuid", "code", "user_type", "uuid_user"];
}
