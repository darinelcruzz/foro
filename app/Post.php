<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use GrahamCampbell\Markdown\Facades\Markdown;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    protected $casts = [
      'pending' => 'boolean'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function latestComments()
    {
      return $this->comments()->orderBy('created_at', 'DESC');
    }

    public function setTitleAttribute($value)
    {
      $this->attributes['title'] = $value;
      $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
      return route('posts.show', [$this->id, $this->slug]);
    }

    public function getSafeHtmlContentAttribute()
    {
      return Markdown::convertToHtml(e($this->content));
    }
}
