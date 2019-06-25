<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['title', 'user_id', 'board_id', 'card_list_id', 'position'];
}
