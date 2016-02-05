<?php

namespace Pedidos\Http\Controllers;

use Auth;
use Pedidos\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
// use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
	public function getSignup()
	{
		if (Auth::user()->is_admin == 1)
		{
			$usuarios=User::all();
			return view('auth.signup')->with('usuarios', $usuarios);
		}
		

		return redirect()->route('auth.signout');
		
	}

	public function postSignup(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|unique:users|email|max:255',
			'username' => 'required|alpha_dash|unique:users|max:20',
			'password' => 'required|min:4|confirmed',
			'password_confirmation' => 'required',
		]);
		
		$supervisor = 0;
		$administrador = 0;
		if(isset($_POST['supervisor'])){
			$supervisor = 1;
		}
		if(isset($_POST['administrador'])){
			$administrador = 1;
		}


		User::create([
			'email' => $request->input('email'),
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
			'restaurante' => $request->input('restaurante'),
			'is_supervisor' => $supervisor,
			'is_admin' => $administrador,
		]);

		return redirect()
			->route('home')
			->with('info', 'Usuario Registrado. Ya puede entrar en la aplicación');
	}

	public function getmodificar($id)
	{
		$usuario = User::where('id', $id)->first();
		return view('auth.detalleUsuario')->with('usuario', $usuario);
	}


	public function postModificar(Request $request, $usuarioId)
	{
		$usuario=User::where('id', $usuarioId)->first();
		if(isset($_POST['estado'])){
			
			$usuario->active = $_POST['estado'];
			unset($_POST['estado']);
			$usuario->save();

			return redirect()->back();
		}

		if(isset($_POST['password'])){
			
			
			$random = random_int(1000, 9999);
			$usuario->password = bcrypt($random);
			$usuario->save();

			return redirect()->back()->with('info','La nueva password provisional es '.$random);
		}

		
		$email = $request->input('email');
		$username = $request->input('username');
		$restaurante = $request->input('restaurante');
		$is_supervisor = 0;
		$is_admin = 0;
		if(isset($_POST['supervisor'])){
			$is_supervisor = 1;
		}
		if(isset($_POST['administrador'])){
			$is_admin = 1;
		}
		
		$usuario->email = $email;
		$usuario->username = $username;
		$usuario->restaurante = $restaurante;
		$usuario->is_admin = $is_admin;
		$usuario->is_supervisor = $is_supervisor;
		
		$usuario->save();

		return redirect()->back()->with('info', 'Datos actualizados');

		
		dd('otro tipo de cambio mas normalito');
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

	public function changePassword(Request $request)
	{
		// $rules = array(
		// 	'old_password' => 'required',
		// 	'new_password' => 'required|confirmed|different:old_password',
		// 	'new_password_confirmation' => 'required|different:old_password|same:new_password',
		// 	);

		$this->validate($request, [		
			'old_password' => 'required',
			'new_password' => 'required|confirmed|different:old_password',
			'new_password_confirmation' => 'required',
		]);
		

		$user = User::find(Auth::user()->id);
		// dd($user);
		// $validator = Validator::make(Input::all(), $rules);

		// if($validator->fails()){
		// 	Session:flash('validationErrors', $validator->messages());
		// 	return Redirect::back()->withInput();
		// }

		if(!Hash::check(Input::get('old_password'), $user->password)){
			// return Redirect::back()->withInput()->withError('La contraseña no es correcta');
			return redirect()->back()->with('info', 'La contraseña no es correcta. Inténtalo de nuevo');
		}

		$user->password = bcrypt(Input::get('new_password'));
		$user->touch();
		$save = $user->save();

		return redirect()->route('home')->with('info', 'La contraseña se ha cambiado correctamente');
	}

}