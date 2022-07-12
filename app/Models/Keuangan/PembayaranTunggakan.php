<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranTunggakan extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_tunggakan';
    protected $guarded = ['id'];
}
