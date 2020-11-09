<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bid';
    protected $guarded = ['id'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_project()
    {
        return $this->belongsTo(Project::class, 'proyek_id');
    }
}
