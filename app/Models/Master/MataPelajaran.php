<?php

namespace App\Models\Master;

use App\Models\Absensi\Jadwal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'mapel_id', 'id');
    }
}
