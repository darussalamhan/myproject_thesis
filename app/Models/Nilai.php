<?php

namespace App\Models;

use App\Models\SubKriteria;
use App\Models\Pemohon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    protected $guarded = [];

    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'subkriteria_id');
    }

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'pemohon_id');
    }
}
