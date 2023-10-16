<?php

namespace App\Models;

use App\Models\Pemohon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    protected $table = 'hasil';
    protected $guarded = [];

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'pemohon_id');
    }
    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'tahun_nilai', 'tahun_nilai');
    }
}

