<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //Relationship between Answer and Question
    public function question()
    {
        $this->belongsTo(Question::class);
    }

    //Relationship between Answer and User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Because answers body in modern syntax we also need to convert it into html using parse library
    public function getBodyHtmlAttribute()
    {
        return \ParseDown::instance()->text($this->body);
    }

}
