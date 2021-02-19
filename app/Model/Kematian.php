<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kematian extends Model
{
    protected $table = 'kematian';
    protected $guarded = ['id'];
    protected $casts = ['lampiran' => 'array'];
}
