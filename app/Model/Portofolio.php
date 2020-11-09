<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolio';
    protected $guarded = ['id'];

    public function get_user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
