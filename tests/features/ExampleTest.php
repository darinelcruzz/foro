<?php

class ExampleTest extends FeatureTestCase
{
    function test_basic_example()
    {

      $user = factory(App\User::class)->create([
        'name' => 'Darinel Cruz',
        'email' => 'darinelcruzz@gmail.com',
      ]);

      $this->actingAs($user, 'api')
           ->visit('api/user')
           ->see('Darinel Cruz')
           ->see('darinelcruzz@gmail.com');
    }
}
