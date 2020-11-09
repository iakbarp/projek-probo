<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UlasanService extends Model
{
    protected $table = 'ulasan_service';
    protected $guarded = ['id'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_pengerjaan()
    {
        return $this->belongsTo(PengerjaanLayanan::class, 'pengerjaan_layanan_id');
    }
}
