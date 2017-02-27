<?php

use App\User;
use App\Post;
use App\Comment;
use App\Notifications\PostCommented;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{

  /**
  * @test
  */
  function it_builds_a_mail_message()
  {
    $post = new Post([
      'title' => 'Título del post',
    ]);

    $author = new User([
      'name' => 'Darinel Cruz',
    ]);

    $comment = new Comment();
    $comment->post = $post;
    $comment->user = $author;

    $notification = new PostCommented($comment);

    $subscriber = new User();

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
