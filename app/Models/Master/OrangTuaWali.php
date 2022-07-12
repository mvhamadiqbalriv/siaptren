<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTuaWali extends Model
{
    use HasFactory;

    protected $table = 'orangtua_wali';
    protected $guarded = ['id'];
    public $timestamps = false;

    // protected function Nama(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => strtoupper($value),
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    // protected function Pekerjaan(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => strtoupper($value),
    //         set: fn ($value) => strtoupper($value)
    //     );
    // }

    public function scopeStatus($query, $status)
    {
        $query->where('status_keluarga', $status);
    }
}
