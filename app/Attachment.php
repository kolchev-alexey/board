<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['user_id', 'card_id', 'file_name', 'file_path', 'file_type'];

        //Make it available in the json response
    protected $appends = ['fileUrl', 'previewUrl'];


    public function getfileUrlAttribute()
    {
        return '/local-file/' . $this->file_path;
    }

    public function getpreviewUrlAttribute()
    {
        return null;
    }
}
