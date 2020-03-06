<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //Relationship between Answer and Question
    public function question()
    {
        return $this->belongsTo(Question::class);
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

    // defining boot method 
    public static function boot()
    {
        //calling parent boot method 
        parent::boot();

        // execute a code when an answer is created 
        // this method recives a cluser as argument to represent the current model instace 
        static::created(function($answer){
            //echo "Answer created\n";
            // increment the answers_count value in the questions table 
            $answer->question->increment('answers_count');
            $answer->question->save();
        });

        // static::saved(function($answer){
        //     echo"Answer saved\n";
        // });
    }

}
