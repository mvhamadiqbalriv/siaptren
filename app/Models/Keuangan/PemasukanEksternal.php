<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukanEksternal extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    protected $guarded = ['id'];

    public function scopeBatal($query, $batal = 1)
    {
        $query->where('batal', $batal);
    }

    public function tanggal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => reverseDate($value),
        );
    }
}
