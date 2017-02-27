<?php

use App\Comment;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class WriteCommentTest extends FeatureTestCase
{
  function test_a_user_can_write_a_comment()
  {
    Notification::fake();
    // Having
    $post = $this->createPost();
    $user = $this->defaultUser();

    // When
    $this->actingAs($user)
          ->visit($post->url)
          ->type('Un comentario', 'comment')
          ->press('Publicar comentario');

    // Then
      $this->seeInDatabase('comments', [
        'comment' => 'Un comentario',
        'user_id' => $user->id,
        'post_id' => $post->id
      ]);

      $this->seePageIS($post->url);
  }

    /*public function test_comments_are_being_paginated()
    {
      // Having
      $post = factory(Post::class)->create();

      $first = factory(Comment::class)->create([
        'comment' => 'Comentario más antiguo',
        'post_id' => $post->id,
        'created_at' => Carbon::now()->subDays(2)
      ]);

      factory(Comment::class)->times(15)->create([
        'post_id' => $post->id,
        'created_at' => Carbon::now()->subDay()
      ]);

      $last = factory(Comment::class)->create([
        'comment' => 'Comentario más reciente',
        'post_id' => $post->id,
        'created_at' => Carbon::now()
      ]);

      // When
      $this->visit($post->url)
          ->see($last->title)
          ->dontSee($first->title)
          ->click('2')
          ->see($first->title)
          ->dontSee($last->title);
    }*/
}
