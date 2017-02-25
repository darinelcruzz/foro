<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use GrahamCampbell\Markdown\Facades\Markdown;

class Comment extends Model
{
  protected $fillable = ['comment', 'post_id'];

  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  function markAsAnswer()
  {
    $this->post->pending = false;
    $this->post->answer_id = $this->id;

    $this->post->save();
  }

  public function getAnswerAttribute()
  {
    return $this->id === $this->post->answer_id;
  }

  public function getSafeHtmlContentAttribute()
  {
    return Markdown::convertToHtml(e($this->comment));
  }
}
