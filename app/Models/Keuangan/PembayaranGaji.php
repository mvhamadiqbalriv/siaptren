<?php

namespace App\Models\Keuangan;

use App\Models\Master\Asatidz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranGaji extends Model
{
    use HasFactory;

    protected $table = 'distribusi_gaji';

    public function asatidz()
    {
        return $this->belongsTo(Asatidz::class, 'asatidz_id', 'id');
    }
}
