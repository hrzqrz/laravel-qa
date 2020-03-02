<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
  protected $fillable = ['title', 'body'];

    // Relationship between Queston model and User
    public function user() {
        return $this->belongsTo(User::class);
    }

    //Relationship between Question model and Answer
    public function answers()
    {
      return $this->hasMany(Answer::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute()
    {
      return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
      return $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute()
    {
      return \Parsedown::instance()->text($this->body);
    }

    // an accessor always start with get and ends with attribute
    public function getSatusAttribute()
    {
      if ($this->answers_count > 0 ) {
        if ($this->best_answer_id) {
          return "answer-accepted";
        }
        return "answered";
      }

      return "unanswered";
    }
}
