<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $guarded = ['id'];

    public function get_project(){
        return $this->belongsTo(Project::class,'proyek_id');
    }
}
