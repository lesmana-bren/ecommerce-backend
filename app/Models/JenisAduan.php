<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisAduan extends Model
{
    protected $primaryKey = 'jenis_aduan_id';
    protected $fillable = ['nama_jenis'];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'jenis_aduan_id', 'jenis_aduan_id');
    }
}