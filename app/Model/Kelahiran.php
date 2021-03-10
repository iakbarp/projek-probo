<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kelahiran extends Model
{
    protected $table = 'kelahiran';
    protected $guarded = ['id'];
    protected $casts = ['lampiran' => 'array'];
    public function get_dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
    public function get_kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function get_bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');

    }
}
