<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Comment;

class MarkCommentAsAnswerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_post_can_be_answered()
    {
        // Having
        $post = $this->createPost();

        $comment = factory(Comment::class)->create([
          'post_id' => $post->id
        ]);

        $comment->markAsAnswer();

        $this->assertTrue($comment->fresh()->answer);

        $this->assertFalse($post->fresh()->pending);
    }

    public function test_a_post_can_only_have_one_answer()
    {
        // Having
        $post = $this->createPost();

        $comments = factory(Comment::class)->times(2)->create([
          'post_id' => $post->id
        ]);

        $comments->first()->markAsAnswer();

        $comments->last()->markAsAnswer();

        $this->assertFalse($comments->first()->fresh()->answer);

        $this->assertTrue($comments->last()->fresh()->answer);
    }
}
