<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusPerubahan extends Model
{
    protected $table = 'perubahan_status';
    protected $guarded = ['id'];
    protected $casts = ['lampiran' => 'array'];
    public function get_dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
}
