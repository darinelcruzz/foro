<?php

class ShowPostTest extends FeatureTestCase
{
    public function test_a_user_can_see_the_post_details()
    {
      // Having
      $user = $this->defaultUser([
        'first_name' => 'Darinel',
        'last_name' => 'Cruz'
      ]);

      $post = $this->createPost([
        'title' => 'Este es el título del post',
        'content' => 'Este es el contenido del post',
        'user_id' => $user->id,
      ]);

      // When
      $this->visit($post->url)
          ->seeInElement('h1', $post->title)
          ->see($post->content)
          ->see('Darinel Cruz');
    }

    public function test_old_urls_are_redirected()
    {
      // Having
      $post = $this->createPost([
        'title' => 'Old title',
      ]);

      $url = $post->url;

      $post->update(['title' => 'New title']);

      $this->visit($url)
          ->seePageIs($post->url);
    }
/*
    public function test_post_url_with_wrong_slugs_still_works()
    {
      // Having
      $user = $this->defaultUser();

      $post = factory(\App\Post::class)->make([
        'title' => 'Old title',
      ]);

      $user->posts()->save($post);

      $url = $post->url;

      $post->update(['title' => 'New title']);

      $this->get($url)
          ->assertResponseOk()
          ->see('New title');

    }
    */
}
