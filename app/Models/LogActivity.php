<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = "log_activities";

    protected $fillable = ["uuid_log_activities", "type_user", "uuid_member_user", "data"];
}
