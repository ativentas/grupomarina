<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    
	/**
	 * Home
	 */

    Route::get('/', [
		'uses' => '\Pedidos\Http\Controllers\HomeController@index',
		'as' => 'home',
	]);

	/**
	 * Authentication
	 */

	Route::get('/signup', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@getSignup',
		'as' => 'auth.signup',
		'middleware' => ['auth'],
	]);

	Route::post('/signup', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@postSignup',
		'middleware' => ['auth'],
	]);

	Route::get('/signin', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@getSignin',
		'as' => 'auth.signin',
		'middleware' => ['guest'],
	]);

	Route::post('/signin', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@postSignin',
		'middleware' => ['guest'],
	]);

	Route::get('/signout', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@getSignout',
		'as' => 'auth.signout',
	]);

	/**
	 * Pedidos
	 */

	Route::get('/abiertos', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@getAbiertos',
		'as' => 'pedidos.abiertos',
		'middleware' => ['auth'],
	]);
	Route::post('/abiertos', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@postPedido',
		'as' => 'pedidos.abiertos',
	]);

	Route::get('/completos', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@getCompletos',
		'as' => 'pedidos.completos',
		'middleware' => ['auth'],
	]);

	Route::delete('/abiertos/borrar/{pedido_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@deletePedido',
		'as' => 'pedido.borrar',
		'middleware' => ['auth'],
	]);

	Route::get('/pedidos/detalle/{pedido_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@getDetalle',
		'as' => 'pedidos.detalle',
		'middleware' => ['auth'],
	]);
	
	Route::post('/pedidos/detalle/{pedido_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@getDetalle',
		'as' => 'pedidos.detalle',
		'middleware' => ['auth'],
	]);

	Route::post('/pedidos/detalle/linea/{pedido_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@postLinea',
		'as' => 'linea.crear',
		'middleware' => ['auth'],
	]);

	Route::delete('/pedidos/detalle/borrar/{linea_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@deleteLinea',
		'as' => 'linea.borrar',
		'middleware' => ['auth'],
	]);

	Route::get('/pedidos/detalle/actualizar/{linea_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@actualizarLinea',
		'as' => 'linea.actualizar',
		'middleware' => ['auth'],
	]);

	Route::post('/pedidos/detalle/actualizar/{linea_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@actualizarLinea',
		'as' => 'linea.actualizar',
		'middleware' => ['auth'],
	]);

	Route::post('/pedidos/completado/{pedido_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@postCompletado',
		'as' => 'pedidos.completado',
		'middleware' => ['auth'],
	]);

});
