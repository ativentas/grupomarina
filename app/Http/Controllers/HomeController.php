<?php

namespace Pedidos\Http\Controllers;

use Auth;

class HomeController extends Controller
{
	public function index()
	{
		if (Auth::check()){
			if(Auth::user()->is_admin){
				return view('home');
			}
			return redirect()->route('pedidos.abiertos');
		}
		return view('home');
	}
}