<?php

namespace Pedidos\Http\Controllers;

use Auth;
use Pedidos\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
	public function getSignup()
	{
		if (Auth::user()->is_admin == 1)
		{
			return view('auth.signup');
		}
		
		return redirect()->route('auth.signout');
		
	}

	public function postSignup(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|unique:users|email|max:255',
			'username' => 'required|alpha_dash|unique:users|max:20',
			'password' => 'required|min:4',
		]);

		User::create([
			'email' => $request->input('email'),
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
			'restaurante' => $request->input('restaurante'),
		]);

		return redirect()
			->route('home')
			->with('info', 'Usuario Registrado. Ya puede entrar en la aplicación');
	}

	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request)
	{
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required',
		]);

		if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => 1], $request->has('remember'))) {
 			return redirect()->route('home')->with('info','Estás dentro');
		}
		return redirect()->back()->with('info', 'Ooops, no es correcto, verifica tus datos');
	}

	public function getSignout()
	{
		Auth::logout();

		return redirect()->route('home')->with('info', 'Has salido!!');
	}

}