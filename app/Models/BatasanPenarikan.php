<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatasanPenarikan extends Model
{
    protected $table = "batasan_penarikan";

    protected $fillable = ["jenis_batasan", "besaran_batasan", "estimasi_waktu_batasan"];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d h:i:s'
    ];
}
