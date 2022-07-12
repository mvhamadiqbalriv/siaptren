<?php

namespace App\Models\Absensi;

use App\Models\Master\Asatidz;
use App\Models\Master\MataPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'mapel_asatidz';
    protected $guarded = [];
    public $incrementing = false;
    public $timestamps = false;

    public function scopeActive($query)
    {
        $query->where('aktif', 1);
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function asatidz()
    {
        return $this->belongsTo(Asatidz::class);
    }
}
