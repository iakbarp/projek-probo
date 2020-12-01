<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $guarded = [
        'id',
        'user_from',
        'user_to',
        'reply_id',
        ];
}
