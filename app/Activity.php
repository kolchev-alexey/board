<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $types = [
		9 => 'add-card',
		10 => 'change-card-title',
		11 => 'change-card-description',
		18 => 'add-comment',
	];

    protected $fillable = ['user_id', 'board_id', 'card_id', 'type', 'detail'];

    protected $casts = [
        // 'detail' => 'array'
    ];

    //Make it available in the json response
    protected $appends = ['class'];


    public function getclassAttribute()
    {
        return isset($this->types[$this->type]) ? $this->types[$this->type] : '';
    }
}
