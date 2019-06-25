<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'team_id'];

    //Add extra attribute
    // protected $attributes = ['personal'];

    //Make it available in the json response
    protected $appends = ['personal'];


    public function getPersonalAttribute()
    {
        return $this->team_id ? false : true;
    }
}
