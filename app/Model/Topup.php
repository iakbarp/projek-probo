<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $table='topup';
    protected $guarded=['id','created_at'];
}
