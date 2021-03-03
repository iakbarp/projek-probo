<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusKematian extends Model
{
    protected $table = 'status_kematian';
    protected $guarded = ['id'];
//    protected $casts = ['lampiran' => 'array'];
    public function get_status()
    {
        return $this->belongsTo(Kematian::class,'kematian_id');
    }
}
