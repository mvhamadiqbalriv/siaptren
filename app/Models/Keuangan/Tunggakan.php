<?php

namespace App\Models\Keuangan;

use App\Models\Master\Santri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tunggakan extends Model
{
    use HasFactory;

    protected $table = 'tunggakan';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id', 'id');
    }
}
