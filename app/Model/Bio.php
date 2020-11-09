<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    protected $table = 'bio';

    protected $guarded = ['id'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }
}
