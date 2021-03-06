<?php

namespace App\Http\Controllers;

use App\User;
use App\Token;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function create()
  {
    return view('register/create');
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'email' => 'required'
    ]);

    $user = User::create($request->all());

    Token::generateFor($user)->sendByEmail();

    return redirect()->route('register_confirmation');
  }

  public function confirm()
  {
    return view('register/confirm');
  }
}
