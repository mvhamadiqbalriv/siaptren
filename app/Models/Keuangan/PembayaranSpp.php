<?php

namespace App\Models\Keuangan;

use App\Models\Master\Santri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSpp extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_spp';
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        $query->where('batal', 0);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id', 'id');
    }
}
