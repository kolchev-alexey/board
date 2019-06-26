<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $types = [
		9 => 'add-card',
		10 => 'change-card-title',
		11 => 'change-card-description',
        14 => 'add-attachment',
		18 => 'add-comment',
	];

    protected $fillable = ['user_id', 'board_id', 'card_id', 'type', 'detail'];

    protected $casts = [
        // 'detail' => 'array'
    ];

    //Make it available in the json response
    protected $appends = ['class', 'actionDetail'];


    public function getclassAttribute()
    {
        return isset($this->types[$this->type]) ? $this->types[$this->type] : '';
    }

    public function getactionDetailAttribute()
    {
        $desc = '';
        switch($this->type) {
            case 9:
                $desc = 'Added this card';
                break;
            case 10:
                $desc = 'Changed card title';
                break;
            case 11:
                $desc = 'Changed card description';
                break;
            case 14:
                $detail = json_decode($this->detail, true);
                $desc = 'Added attachment ' . $detail['fileName'];
                break;
            case 18:
                $detail = json_decode($this->detail, true);
                $desc = $detail['comment'];
                break;            
        }

        return $desc;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
