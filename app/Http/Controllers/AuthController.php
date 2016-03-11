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
			
			$usuariosAdministradores=User::where('is_admin',1)->where('is_root',0)->get();
			$usuariosNormales=User::where('is_admin',0)->where('is_root',0)->get();
			return view('auth.signup')
				->with('usuariosAdministradores', $usuariosAdministradores)
				->with('usuariosNormales', $usuariosNormales)
				;
		}
		
		return redirect()->route('auth.signout');		
	}

	public function postSignup(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|unique:users|email|max:255',
			'nombre' => 'required|min:4|max:35',
			'username' => 'required|alpha_dash|unique:users|max:20',
			'password' => 'required|min:4|confirmed',
			'password_confirmation' => 'required',
			'restaurante' => 'required',
			'empresa' => 'required',
			'entrada' => 'date_format:H:i',
			'salida' => 'date_format:H:i',
			'entrada2' => 'date_format:H:i',
			'salida2' => 'date_format:H:i',
			
		]);
		
		$supervisor = 0;
		$administrador = 0;
		$turno_partido = 0;
		if(isset($_POST['supervisor'])){
			$supervisor = 1;
		}
		if(isset($_POST['administrador'])){
			$administrador = 1;
		}		
		if(isset($_POST['turnoPartido'])){
			$turno_partido = 1;
		}
		// dd($request->input('entrada'));

		if ($request->input('entrada') == null) {
			$entrada = null;
		}else {
			$entrada = date("H:i",strtotime($request->input('entrada')));}
		if ($request->input('salida') == null) {
			$salida = null;
		}else {
			$salida = date("H:i",strtotime($request->input('salida')));}
		if ($request->input('entrada2') == null) {
			$entrada2 = null;
		}else {
			$entrada2 = date("H:i",strtotime($request->input('entrada2')));}
		if ($request->input('salida2') == null) {
			$salida2 = null;
		}else {
			$salida2 = date("H:i",strtotime($request->input('salida2')));}

		User::create([
			'email' => $request->input('email'),
			'nombre_completo' => $request->input('nombre'),
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
			'restaurante' => $request->input('restaurante'),
			'empresa' => $request->input('empresa'),
			'is_supervisor' => $supervisor,
			'is_admin' => $administrador,
			'entrada' => $entrada,
			'salida' => $salida,
			'turno_partido' => $turno_partido,
			'entrada2' => $entrada,
			'salida2' => $salida2,
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
		$this->validate($request, [
			'email' => 'required|email|max:255|unique:users,email,'.$usuarioId,
			'nombre' => 'required|min:4|max:35',
			'restaurante' => 'required',
			'empresa' => 'required',
			'entrada' => 'date_format:H:i',
			'salida' => 'date_format:H:i',
			'entrada2' => 'date_format:H:i',
			'salida2' => 'date_format:H:i',
		]);

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
		$nombre = $request->input('nombre');
		$restaurante = $request->input('restaurante');
		$empresa = $request->input('empresa');
		$entrada = $request->input('entrada');
		$salida = $request->input('salida');
		$entrada2 = $request->input('entrada2');
		$salida2 = $request->input('salida2');
		$is_supervisor = $usuario->is_supervisor;
		$is_admin = $usuario->is_admin;

		if(isset($_POST['turnoPartido'])){
			$turno_partido = 1;
			$usuario->turno_partido = $turno_partido;
		}else{$usuario->turno_partido = 0;}
		if(isset($_POST['supervisor'])){
			$is_supervisor = 1;
			$usuario->is_supervisor = $is_supervisor;
		}else{$usuario->is_supervisor = 0;}
		if(isset($_POST['administrador'])){
			$is_admin = 1;
			$usuario->is_admin = $is_admin;
		}else{$usuario->is_admin = 0;}
		
		$usuario->email = $email;
		$usuario->username = $username;
		$usuario->nombre_completo = $nombre;
		$usuario->restaurante = $restaurante;
		$usuario->empresa = $empresa;
		$usuario->entrada = $entrada;
		$usuario->salida = $salida;
		$usuario->entrada2 = $entrada2;	
		$usuario->salida2 = $salida2;	
		
		$usuario->save();

		return redirect()->route('auth.signup')->with('info', 'Datos actualizados');
	
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
 			$info='Bienvenido, '.Auth::user()->username;
 			Auth::user()->touch();
 			return redirect()->route('home')->with('info', $info);
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