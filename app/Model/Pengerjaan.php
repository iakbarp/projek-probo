<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pengerjaan extends Model
{
    protected $table = 'pengerjaan';
    protected $guarded = ['id'];
    protected $casts = ['file_hasil' => 'array'];

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
