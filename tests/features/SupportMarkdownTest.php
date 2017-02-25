<?php

class SupportMarkdownTest extends FeatureTestCase
{
    public function test_the_post_content_supports_markdown()
    {
        $importantText = 'Un texto muy importante';

        $post = factory(\App\Post::class)->create([
          'content' => "La primera parte del texto. **$importantText**. La ultima parte del texto",
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);
    }

    public function test_the_post_comments_support_markdown()
    {
        $importantText = 'Un texto muy importante';

        $comment = factory(\App\Comment::class)->create([
          'comment' => "La primera parte del texto. **$importantText**. La ultima parte del texto",
        ]);

        $this->visit($comment->post->url)
            ->seeInElement('strong', $importantText);
    }

    public function test_the_code_in_the_post_is_escaped()
    {
      $xssAttack = "<script>alert('Malicious JS!')</script>";

      $post = $this->createPost([
        'content' => "`$xssAttack`. Texto normal."
      ]);

      $this->visit($post->url)
          ->dontSee($xssAttack)
          ->seeText('Texto normal')
          ->seeText($xssAttack);
    }

    public function test_xss_attack()
    {
      $xssAttack = "<script>alert('Malicious JS!')</script>";

      $post = $this->createPost([
        'content' => "$xssAttack. Texto normal."
      ]);

      $this->visit($post->url)
          ->dontSee($xssAttack)
          ->seeText('Texto normal')
          ->seeText($xssAttack);
    }

    public function test_xss_attack_with_html()
    {
      $xssAttack = "<img src='img.jpg'>";

      $post = $this->createPost([
        'content' => "$xssAttack. Texto normal."
      ]);

      $this->visit($post->url)
          ->dontSee($xssAttack);
    }
}
