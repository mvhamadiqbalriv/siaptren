<?php

namespace App\Models\Master;

use App\Models\Absensi\AbsensiAsatidz;
use App\Models\Absensi\Jadwal;
use App\Models\Keuangan\PembayaranGaji;
use Database\Factories\AsatidzFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asatidz extends Model
{
    use HasFactory;

    protected $table = 'asatidz';
    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return AsatidzFactory::new();
    }

    public function scopeActive($query)
    {
        $query->where('aktif', 1);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'asatidz_id', 'id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiAsatidz::class, 'asatidz_id', 'id');
    }

    public function absensiHariIni()
    {
        return $this->hasOne(AbsensiAsatidz::class, 'asatidz_id', 'id')->whereDate('tanggal', date('Y-m-d'));
    }

    public function pembayaranGaji()
    {
        return $this->hasMany(PembayaranGaji::class, 'asatidz_id', 'id');
    }

    public function pasFoto()
    {
        return $this->hasOne(FileUpload::class, 'ref_id', 'id')->tipe('asatidz')->jenis('Foto');
    }

    public function kk()
    {
        return $this->hasOne(FileUpload::class, 'ref_id', 'id')->tipe('asatidz')->jenis('KK');
    }

    public function ktp()
    {
        return $this->hasOne(FileUpload::class, 'ref_id', 'id')->tipe('asatidz')->jenis('KTP');
    }
}
