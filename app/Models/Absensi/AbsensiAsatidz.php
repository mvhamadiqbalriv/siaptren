<?php

namespace App\Models\Absensi;

use App\Models\Master\Asatidz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiAsatidz extends Model
{
    use HasFactory;

    protected $table = 'absensi_asatidz';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function asatidz()
    {
        return $this->belongsTo(Asatidz::class, 'asatidz_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'kode_jadwal', 'kode_jadwal');
    }
}
