<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    protected $guarded = ['id'];

    public function get_kota()
    {
        return $this->hasMany(Kota::class, 'provinsi_id');
    }
}
