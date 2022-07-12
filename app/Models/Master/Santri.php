<?php

namespace App\Models\Master;

use App\Models\Absensi\AbsensiSantri;
use App\Models\Keuangan\PembayaranSpp;
use App\Models\Keuangan\Tunggakan;
use Database\Factories\SantriFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';
    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return SantriFactory::new();
    }

    public function scopeActive($query)
    {
        $query->where('status', 'Aktif');
    }

    public function scopeLulus($query)
    {
        $query->where('status', 'Lulus');
    }

    public function ayah()
    {
        return $this->hasOne(OrangTuaWali::class, 'santri_id', 'id')->status('Ayah');
    }

    public function ibu()
    {
        return $this->hasOne(OrangTuaWali::class, 'santri_id', 'id')->status('Ibu');
    }

    public function wali()
    {
        return $this->hasOne(OrangTuaWali::class, 'santri_id', 'id')->status('Wali');
    }

    public function pasFoto()
    {
        return $this->hasOne(FileUpload::class, 'ref_id', 'id')->tipe('santri')->jenis('Foto');
    }

    public function kk()
    {
        return $this->hasOne(FileUpload::class, 'ref_id', 'id')->tipe('santri')->jenis('KK');
    }

    public function ktp()
    {
        return $this->hasOne(FileUpload::class, 'ref_id', 'id')->tipe('santri')->jenis('KTP');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiSantri::class, 'santri_id', 'id');
    }

    public function tunggakan()
    {
        return $this->hasOne(Tunggakan::class, 'santri_id', 'id');
    }

    public function pembayaranSpp()
    {
        return $this->hasMany(PembayaranSpp::class, 'santri_id', 'id');
    }

    // protected function NamaLengkap(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    // protected function TempatLahir(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    // protected function Universitas(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    // protected function Fakultas(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    // protected function Prodi(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    // protected function email(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtolower($value)
    //     );
    // }
}
