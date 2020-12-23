<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $table='topup';
    protected $guarded=['id','created_at'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
