<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PengerjaanProgress extends Model
{
    protected $table = 'pengerjaan_progress';
    protected $guarded = ['id'];
    protected $casts = ['bukti_gambar' => 'array'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_project()
    {
        return $this->belongsTo(Project::class, 'proyek_id');
    }

    public function get_ulasan_pekerja()
    {
        return $this->hasOne(ReviewWorker::class, 'pengerjaan_id');
    }
}
