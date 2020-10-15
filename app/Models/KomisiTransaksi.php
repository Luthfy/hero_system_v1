<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomisiTransaksi extends Model
{
    protected $table = "komisi_transaksi";

    protected $fillable = ["jenis_komisi", "besaran_komisi"];

    protected $casts = [
        'created_at' => 'date:y-m-d',
        'updated_at' => 'date:y-m-d h:i:s'
    ];
}
