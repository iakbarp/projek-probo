<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PembayaranLayanan extends Model
{
    protected $table = 'pembayaran_layanan';
    protected $guarded = ['id'];

    public function get_pengerjaan_layanan()
    {
        return $this->belongsTo(PengerjaanLayanan::class, 'pengerjaan_layanan_id');
    }
}
