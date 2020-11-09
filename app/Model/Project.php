<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $guarded = ['id'];
    protected $casts = ['lampiran' => 'array'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_sub()
    {
        return $this->belongsTo(SubKategori::class, 'subkategori_id');
    }

    public function get_bid()
    {
        return $this->hasMany(Bid::class, 'proyek_id');
    }

    public function get_undangan()
    {
        return $this->hasOne(Undangan::class, 'proyek_id');
    }

    public function get_pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'proyek_id');
    }

    public function get_pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'proyek_id');
    }

    public function get_ulasan()
    {
        return $this->hasOne(Review::class, 'proyek_id');
    }
}
