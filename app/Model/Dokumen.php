<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'status_dokumen';
    protected $guarded = ['id'];
//    protected $casts = ['lampiran' => 'array'];
    public function get_kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
