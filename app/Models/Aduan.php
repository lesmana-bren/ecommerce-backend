<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    protected $primaryKey = 'aduan_id';
    protected $fillable = ['user_id', 'jenis_aduan_id', 'aduan', 'priority'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisAduan()
    {
        return $this->belongsTo(JenisAduan::class, 'jenis_aduan_id', 'jenis_aduan_id');
    }
}