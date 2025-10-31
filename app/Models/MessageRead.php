<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageRead extends Model
{
    protected $table = 'message_reads';
    public $timestamps = false;

    protected function casts()
    {
        return [
            'read_at' => 'datetime',
        ];
    }
}
