<?php

use App\Notifications\PostCommented;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{
  use DatabaseTransactions;

  /**
  * @test
  */
  function it_builds_a_mail_message()
  {
    $post = factory(\App\Post::class)->create([
      'title' => 'Título del post',
    ]);

    $author = factory(\App\User::class)->create([
      'name' => 'Darinel Cruz',
    ]);

    $comment = factory(\App\Comment::class)->create([
      'post_id' => $post->id,
      'user_id' => $author->id
    ]);

    $notification = new PostCommented($comment);

    $subscriber = factory(\App\User::class)->create();

    $message = $notification->toMail($subscriber);

    $this->assertInstanceOf(MailMessage::class, $notification->toMail($subscriber));

    $this->assertSame('Nuevo comentario en: Título del post', $message->subject);

    $this->assertSame(
      'Darinel Cruz escribió un comentario en: Título del post',
      $message->introLines[0]
    );

    $this->assertSame($comment->post->url, $message->actionUrl);
  }
}
