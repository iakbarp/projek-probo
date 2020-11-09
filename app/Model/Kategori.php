<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $guarded = ['id'];

    public function get_sub()
    {
        return $this->hasMany(SubKategori::class,'kategori_id');
    }
}
