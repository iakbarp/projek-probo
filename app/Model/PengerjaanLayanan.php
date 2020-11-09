<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PengerjaanLayanan extends Model
{
    protected $table = 'pengerjaan_layanan';
    protected $guarded = ['id'];
    protected $casts = ['file_hasil' => 'array'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function get_pembayaran()
    {
        return $this->hasOne(PembayaranLayanan::class, 'pengerjaan_layanan_id');
    }

    public function get_ulasan()
    {
        return $this->hasOne(UlasanService::class, 'pengerjaan_layanan_id');
    }
}
