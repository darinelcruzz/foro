<?php

class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
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
}
