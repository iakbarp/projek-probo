<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';

    protected $guarded = ['id'];

    public function get_provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }
}
