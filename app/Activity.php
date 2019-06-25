<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'board_id', 'card_id', 'type', 'detail'];

    protected $casts = [
        // 'detail' => 'array'
    ];
}
