<?php

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::resource('pais',PaisController::class,['only'=>['index','show']]);
Route::resource('pais.provincias',PaisProvinciaController::class,['only'=>['index']]);
Route::resource('provincias',ProvinciaController::class,['only'=>['index','show']]);
Route::resource('provincias.localidads',ProvinciaLocalidadController::class,['only'=>['index']]);
Route::resource('localidads',LocalidadController::class,['only'=>['index','show']]);
Route::get('users/verify/{token}','UserController@verify')->name('verify');
Route::resource('users',UserController::class,['except'=>['create','edit']]);
Route::resource('trayectos',TrayectoController::class,['except'=>['create','edit']]);
Route::resource('seguros',SeguroController::class,['except'=>['create','edit']]);
Route::resource('tipo_asientos',TipoAsientoController::class,['except'=>['create','edit']]);
Route::resource('trayectos.seguros',TrayectoSeguroController::class,['only'=>['index']]);
Route::resource('pais.trayectos',PaisTrayectoController::class,['only'=>['index']]);
Route::resource('provincias.trayectos',ProvinciaTrayectoController::class,['only'=>['index']]);
Route::resource('localidads.trayectos',LocalidadTrayectoController::class,['only'=>['index']]);
Route::resource('trayectos.tipo_asientos',TrayectoTipoAsientoController::class,['only'=>['index']]);
Route::resource('asientos',AsientoController::class,['except'=>['create','edit']]);
Route::resource('trayectos.asientos',TrayectoAsientoController::class,['only'=>['index']]);
Route::resource('tipo_asientos.asientos',TipoAsientoAsientoController::class,['only'=>['index']]);
Route::get('temporadas/{Trayecto}/pertenece','TemporadaController@pertenece')->name('temporada.pertenece');
Route::get('temporadas/{Trayecto}/puedeReservarse','TemporadaController@puedeReservarse')->name('temporada.puedeReservarse');
Route::resource('temporadas',TemporadaController::class,['except'=>['create','edit','update']]);
Route::get('trayectos/{Trayecto}/Precios/descriptivo','TrayectoPrecioController@descriptivo')->name('Trayectos.Precios.descriptivo');
Route::get('precios/{Precio}/descriptivo','PrecioController@descriptivo')->name('Precios.descriptivo');
Route::resource('Precios',PrecioController::class,['except'=>['create','edit','store']]);
Route::get('trayectos/{Trayecto}/Precios/generar','TrayectoPrecioController@generar')->name('Trayectos.Precios.generar');
Route::resource('trayectos.Precios',TrayectoPrecioController::class,['except'=>['create','edit','store','update','destroy']]);
Route::get('trayectos/{Trayecto}/fechas/abrir','TrayectoFechaController@abrir')->name('Trayectos.fechas.abrir');
Route::get('trayectos/{Trayecto}/fechas/cerrar','TrayectoFechaController@cerrar')->name('Trayectos.fechas.cerrar');
Route::resource('trayectos.fechas',TrayectoFechaController::class,['except'=>['create','edit','store','update','destroy']]);
Route::get('clientes/nif','ClienteController@lookforNIF')->name('cliente.nif');
Route::resource('clientes',ClienteController::class,['except'=>['create','edit']]);
Route::resource('tarjetas',TarjetaController::class,['except'=>['create','edit']]);
Route::resource('clientes.tarjetas',ClienteTarjetaController::class,['except'=>['create','edit','store','update','destroy']]);
Route::resource('reservas',ReservaController::class,['except'=>['create','edit']]);
Route::resource('clientes.reservas',ClienteReservaController::class,['except'=>['create','edit','store','update','destroy']]);
Route::resource('Trayectos.reservas',TrayectoReservaController::class,['except'=>['create','edit','store','update','destroy']]);
Route::get('asientos/{Asiento}/fechas/libre','AsientoFechaController@libre')->name('Asientos.fechas.libre');
Route::get('asientos/{Asiento}/fechas/ocupado','AsientoFechaController@ocupado')->name('Asientos.fechas.ocupado');
Route::resource('Asientos.fechas',AsientoFechaController::class,['except'=>['create','edit','store','update','destroy']]);
Route::resource('Asientos.reservas',AsientoReservaController::class,['except'=>['create','edit','store','update','destroy']]);
Route::resource('Asientos.precios',AsientoPrecioController::class,['except'=>['create','edit','store','update','destroy']]);
Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->name('passport.token');
Route::get('precios/{Precio}/Asientos/fechas','PrecioAsientoController@fechas')->name('Precios.asientos.fechas');
Route::resource('precios.asientos',PrecioAsientoController::class,['only'=>['index','show']]);
Route::resource('precios.trayectos',PrecioTrayectoController::class,['only'=>['index']]);
Route::post('reservas/fechas','ReservaFechaController@store')->name('reservas.fechas.store');
