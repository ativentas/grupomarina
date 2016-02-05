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

	Route::get('/usuarios/modificar/{id}', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@getmodificar',
		'as' => 'usuarios.modificar',
		'middleware' => ['auth'],
	]);

	Route::post('/usuarios/modificar/{id}', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@postmodificar',
		'as' => 'usuarios.modificar',
		'middleware' => ['auth'],
	]);

	Route::get('/user/changepwd', [
		'as' => 'user.cambioPassword',
		function(){return view('auth.cambioPassword');},
		'middleware' => ['auth'],
	]);

	Route::post('/user/changepwd', [
		'uses' => '\Pedidos\Http\Controllers\AuthController@changePassword',
		'middleware' => ['auth'],
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

	Route::post('/pedidos/descompletado/{pedido_id}', [
		'uses' => '\Pedidos\Http\Controllers\PedidoController@postDescompletado',
		'as' => 'pedidos.descompletado',
		'middleware' => ['auth'],
	]);

	/**
	 * Inventarios
	 */

	Route::get('/inventario/pendientes', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getPendientes',
		'as' => 'inventarios.pendientes',
		'middleware' => ['auth'],
	]);

	Route::get('/inventarios/completos', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getInventariosCompletos',
		'as' => 'inventarios.completos',
		'middleware' => ['auth'],
	]);


	Route::get('/inventario/detalle/', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getInventario',
		'as' => 'inventarios.detalle',
		'middleware' => ['auth'],
	]);
	
	Route::get('/inventario/detalle/{inventario_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getInventario',
		'as' => 'inventarios.detalle',
		'middleware' => ['auth'],
	]);

	Route::post('/inventario/detalle/{inventario_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getInventario',
		'as' => 'inventarios.detalle',
		'middleware' => ['auth'],
	]);

	Route::post('/inventario/detalle/linea/{inventario_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@nuevaLineaInventario',
		'as' => 'lineaInventario.crear',
		'middleware' => ['auth'],
	]);

	Route::post('/inventario/detalle/actualizar/{linea_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@actualizarLineaInventario',
		'as' => 'lineaInventario.actualizar',
		'middleware' => ['auth'],
	]);

	Route::delete('/inventario/detalle/eliminar/{linea_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@deleteLineaInventario',
		'as' => 'lineaInventario.eliminar',
		'middleware' => ['auth'],
	]);



	Route::post('/inventario/fichero/{inventario_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@postFicheroInventario',
		'as' => 'inventarios.fichero',
		'middleware' => ['auth'],
	]);

	Route::post('/inventario/completo/{inventario_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@postCompletoInventario',
		'as' => 'inventarios.completo',
		'middleware' => ['auth'],
	]);

	Route::get('/inventario/admin', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getAdminInventarios',
		'as' => 'inventarios.admin',
		'middleware' => ['auth'],
	]);

	Route::post('/inventario/nuevo', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@crearInventario',
		'as' => 'inventario.crear',
		'middleware' => ['auth'],
	]);

	Route::delete('/inventario/borrar/{inventario_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@borrarInventario',
		'as' => 'inventario.borrar',
		'middleware' => ['auth'],
	]);

	/**
	 * Plantillas
	 */

	Route::get('/plantillas/admin', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getAdminPlantillas',
		'as' => 'plantillas.admin',
		'middleware' => ['auth'],
	]);

	Route::post('/plantilla/nueva', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@crearPlantilla',
		'as' => 'plantilla.nueva',
		'middleware' => ['auth'],
	]);

	Route::get('/plantilla/detalle/{plantilla_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getPlantilla',
		'as' => 'plantilla.detalle',	
		'middleware' => ['auth'],
	]);

	Route::post('/plantilla/detalle/{plantilla_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@getPlantilla',
		'as' => 'plantilla.detalle',
		'middleware' => ['auth'],
	]);

	Route::delete('/plantilla/borrar/{plantilla_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@borrarPlantilla',
		'as' => 'plantilla.borrar',
		'middleware' => ['auth'],
	]);

	Route::post('/plantilla/detalle/linea/{plantilla_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@postLineaPlantilla',
		'as' => 'lineaPlantilla.crear',
		'middleware' => ['auth'],
	]);

	Route::delete('/plantilla/detalle/borrar/{linea_id}', [
		'uses' => '\Pedidos\Http\Controllers\InventarioController@deleteLineaPlantilla',
		'as' => 'lineaPlantilla.borrar',
		'middleware' => ['auth'],
	]);


});
