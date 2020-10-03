<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomisiTransaksi extends Model
{
    protected $table = "komisi_transaksi";

    protected $fillable = ["jenis_komisi", "besaran_komisi"]
}
