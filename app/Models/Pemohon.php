<?php

namespace App\Models;

use App\Models\Nilai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    use HasFactory;

    protected $table = 'pemohon';
    protected $guarded = [];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'pemohon_id');
    }
    public function sub_kriteria()
    {
        return $this->hasManyThrough(SubKriteria::class, Nilai::class, 'pemohon_id', 'id', 'id', 'subkriteria_id');
    }
}
