<?php

use App\User;
use App\Token;
use App\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
  function test_a_guest_user_can_create_an_account()
  {
    Mail::fake();

    $this->visitRoute('register')
        ->type('darinelcruzz@gmail.com', 'email')
        ->type('darinelcruzz', 'username')
        ->type('Darinel', 'first_name')
        ->type('Cruz', 'last_name')
        ->press('Regístrate');

    $this->seeInDatabase('users', [
      'email' => 'darinelcruzz@gmail.com',
      'username' => 'darinelcruzz',
      'first_name' => 'Darinel',
      'last_name' => 'Cruz',
    ]);

    $user = User::first();

    $this->seeInDatabase('tokens', [
      'user_id' => $user->id
    ]);

    $token = Token::where('user_id', $user->id)->first();

    $this->assertNotNull($token);

    Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token) {
      return $mail->token->id == $token->id;
    });

    $this->seeRouteIs('register_confirmation')
        ->see('Gracias por registrarte')
        ->see('Envíamos a tu email un enlace para que inicies sesión');
  }

  public function test_a_guest_user_can_create_an_account_without_an_email()
  {
    // When
    $this->visitRoute('register')
        ->type('darinelcruzz', 'username')
        ->type('Darinel', 'first_name')
        ->type('Cruz', 'last_name')
        ->press('Regístrate');

    $this->seeErrors([
      'email' => 'El campo correo electrónico es obligatorio'
    ]);
  }

  /**
  * @todo add the other validations
  */
}
