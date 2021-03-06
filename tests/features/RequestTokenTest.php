<?php

use App\User;
use App\Token;
use App\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;

class RequestTokenTest extends FeatureTestCase
{
  public function test_a_guest_user_can_request_a_token()
  {
    // Having
    Mail::fake();

    $user = $this->defaultUser(['email' => 'darinelcruzz@gmail.com']);

    // When
    $this->visitRoute('token')
        ->type('darinelcruzz@gmail.com', 'email')
        ->press('Solicitar token');

    // Then a new token is created in the database
    $token = Token::where('user_id', $user->id)->first();

    $this->assertNotNull($token);

    // And sent to the user
    Mail::assertSent(TokenMail::class, function ($mail) use ($token, $user) {
      return $mail->hasTo($user) && $mail->token->id === $token->id;
    });

    $this->dontSeeIsAuthenticated();

    $this->see('Envíamos a tu email un enlace para que inicies sesión');
  }

  public function test_a_guest_user_can_request_a_token_without_an_email()
  {
    // Having
    Mail::fake();

    // When
    $this->visitRoute('token')
        ->press('Solicitar token');

    // Then a new token is NOT created in the database
    $token = Token::first();

    $this->assertNull($token);

    // And sent to the user
    Mail::assertNotSent(TokenMail::class);

    $this->dontSeeIsAuthenticated();

    $this->seeErrors([
      'email' => 'El campo correo electrónico es obligatorio'
    ]);
  }

  public function test_a_guest_user_can_request_a_token_an_invalid_email()
  {
    // When
    $this->visitRoute('token')
        ->type('darinel', 'email')
        ->press('Solicitar token');

    $this->seeErrors([
      'email' => 'Correo electrónico no es un correo válido'
    ]);
  }

  public function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
  {
    // Having
    $this->defaultUser(['email' => 'darinelcruzz@gmail.com']);

    // When
    $this->visitRoute('token')
        ->type('darinelvazqez@gmail.com', 'email')
        ->press('Solicitar token');

    $this->seeErrors([
      'email' => 'Correo electrónico es inválido'
    ]);
  }
}
