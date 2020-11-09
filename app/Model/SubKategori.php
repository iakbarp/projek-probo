<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table = 'subkategori';
    protected $guarded = ['id'];

    public function get_kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function get_project()
    {
        return $this->hasMany(Project::class, 'subkategori_id');
    }

    public function get_service()
    {
        return $this->hasMany(Services::class, 'subkategori_id');
    }
}
