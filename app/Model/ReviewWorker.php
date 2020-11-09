<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ReviewWorker extends Model
{
    protected $table = 'ulasan_pekerja';
    protected $guarded = ['id'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_pengerjaan()
    {
        return $this->belongsTo(Pengerjaan::class, 'pengerjaan_id');
    }
}
