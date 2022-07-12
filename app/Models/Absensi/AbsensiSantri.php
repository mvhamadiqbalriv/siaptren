<?php

namespace App\Models\Absensi;

use App\Models\Master\Santri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSantri extends Model
{
    use HasFactory;

    protected $table = 'absensi_santri';
    protected $guarded = ['id'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
