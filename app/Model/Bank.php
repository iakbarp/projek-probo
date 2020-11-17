<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Bank extends Model
{
    protected $table = 'bank';

    protected $guarded = ['id','created_at'];

    public function get_user()
    {
        return $this->hasOne(User::class, 'bank');
    }
}
