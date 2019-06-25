<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardList extends Model
{
    protected $fillable = ['name', 'user_id', 'board_id', 'position'];
}
