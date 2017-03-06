<?php

namespace Tests\Browser;

use App\Category;
use App\Post;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTests extends DuskTestCase
{
  use DatabaseMigrations;

  protected $title = 'Esta es una pregunta';
  protected $content = 'Este es el contenido';

  public function test_a_user_creates_a_post()
  {
    $user = $this->defaultUser();

    $category = factory(Category::class)->create();

    $this->browse(function ($browser) use ($user, $category) {
      $browser->loginAs($user)
          ->visitRoute('posts.create')
          ->type('title', $this->title)
          ->type('content', $this->content)
          ->select('category_id', (string) $category->id)
          ->press('Publicar')
          ->assertPathIs('/posts/1-esta-es-una-pregunta');
    });

    // Then
    $this->assertDatabaseHas('posts', [
      'title' => $this->title,
      'content' => $this->content,
      'pending' => true,
      'user_id' => $user->id,
      'slug' => 'esta-es-una-pregunta',
    ]);

    $post = Post::first();

    // Test the author is automatically subscribed to the post
    $this->assertDatabaseHas('subscriptions', [
      'user_id' => $user->id,
      'post_id' => $post->id,
    ]);
  }

  public function test_creating_a_post_requires_authentication()
  {
    $this->browse(function ($browser) {
      $browser->visitRoute('posts.create')
          ->assertRouteIs('token');
    });
  }

  public function test_create_post_form_validation()
  {
    $this->browse(function($browser) {
      $browser->loginAs($this->defaultUser())
          ->visitRoute('posts.create')
          ->press('Publicar')
          ->assertRouteIs('posts.create')
          ->assertSeeErros([
            'title' => 'El campo título es obligatorio',
            'content' => 'El campo contenido es obligatorio'
          ]);
    });
  }
}
