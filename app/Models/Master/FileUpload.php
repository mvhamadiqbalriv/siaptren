<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'upload';
    protected $guarded = ['id'];

    public function scopeTipe($query, $tipe)
    {
        $query->where('ref_tipe', $tipe);
    }

    public function scopeJenis($query, $jenis)
    {
        $query->where('jenis', $jenis);
    }
}
