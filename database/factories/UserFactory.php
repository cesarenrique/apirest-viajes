<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Localidad;
use App\Trayecto;
use App\Seguro;
use App\TipoAsiento;
use App\Cliente;
use App\Tarjeta;
use App\Precio;
use App\Fecha;
use App\Temporada;
use App\Reserva;
use App\Asiento;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
  static $password;

  return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'password' => $password ?: $password = bcrypt('secret'),
      'remember_token' => Str::random(10),
      'verified'=> $verificado= $faker->randomElement([User::USUARIO_VERIFICADO,User::USUARIO_NO_VERIFICADO]),
      'verify_Token'=> $verificado== User::USUARIO_VERIFICADO ? null : User::generateVerificationToken(),
      'tipo_usuario' => $faker->randomElement([User::USUARIO_CLIENTE,User::USUARIO_EDITOR,User::USUARIO_ADMINISTRADOR]),
  ];
});

$factory->define(App\Trayecto::class, function (Faker $faker) {
    $localidad= Localidad::All()->random();
    $values="";
    for($i=0;$i<8;$i++){
      $aux=$faker->randomDigit;
      $values=$values .  strval($aux);
    }
    $numero=intval($values);
    $resto=$numero%23;
    $letra=array('T','R','W','A','G','M','Y','F','P','D','X','B',
                'N','J','Z','S','Q','V','H','L','C','K','E');
    $values=$values. $letra[$resto];
    return [
      'nombre' => $faker->name,
      'NIF' => $values,
      'Localidad_id'=> $localidad->id,
    ];
});
$factory->define(App\Seguro::class, function (Faker $faker) {
    $Trayecto=Trayecto::All()->random();
    return [
       'tipo'=> $faker->randomElement([Seguro::SEGURO_DESAYUNO,Seguro::SEGURO_COMPLETA,Seguro::SEGURO_COMPLETA_CENA]),
       'Trayecto_id'=>$Trayecto->id,
    ];
});

$factory->define(App\TipoAsiento::class, function (Faker $faker) {
    $Trayecto=Trayecto::All()->random();
    return [
       'tipo'=> $faker->randomElement([TipoAsiento::ASIENTO_SIMPLE,TipoAsiento::ASIENTO_DOBLE,TipoAsiento::ASIENTO_MATRIMONIAL]),
       'Trayecto_id'=>$Trayecto->id,
    ];
});

$factory->define(App\Asiento::class, function (Faker $faker) {
    $Trayecto= Trayecto::All()->random();
    $tipo= $faker->randomElement(TipoAsiento::where('Trayecto_id',$Trayecto->id)->get());
    $numero=0;
    $numero=$faker->numberBetween($min=1,$max=400);
    $ceros="";
    if($numero<10) $ceros="00";
    if(10<$numero && $numero<100) $ceros="0";
    $numero2=$ceros.$numero;
    $empresa= $faker->company();
    return [
       'numero'=> $numero2,
       'empresa'=> $empresa,
       'Trayecto_id'=> $Trayecto->id,
       'tipo_Asiento_id'=> $tipo->id,
     ];
});

$factory->define(App\Cliente::class, function (Faker $faker) {
  $values="";
  for($i=0;$i<8;$i++){
    $aux=$faker->randomDigit;
    $values=$values .  strval($aux);
  }
  $numero=intval($values);
  $resto=$numero%23;
  $letra=array('T','R','W','A','G','M','Y','F','P','D','X','B',
              'N','J','Z','S','Q','V','H','L','C','K','E');
  $values=$values. $letra[$resto];

  return [
     'NIF'=> $values,
     'nombre'=> $faker->name,
     'email'=> $faker->unique()->email,
     'telefono'=> $faker->phoneNumber,

  ];
});
$factory->define(App\Tarjeta::class, function (Faker $faker) {
    $cliente=Cliente::All()->random();

    return [
       'numero'=> $faker->creditCardNumber,
       'Cliente_id'=> $cliente->id,

    ];
});

$factory->define(App\Reserva::class, function (Faker $faker) {
    $tarjeta=Tarjeta::All()->random();
    $cliente=Cliente::find($tarjeta->Cliente_id);
    $Asiento=Asiento::All()->random();
    $temporada=Temporada::where('Trayecto_id',$Asiento->Trayecto_id)->get()->random();
    $fecha=Fecha::where('Trayecto_id',$Asiento->Trayecto_id)
            ->whereBetween('abierto',[$temporada->fecha_desde,$temporada->fecha_hasta])
            ->get()->random();
    $Seguro=Seguro::where('Trayecto_id',$Asiento->Trayecto_id)->get()->random();

    $Precio=Precio::where('Temporada_id',$temporada->id)
      ->where('Seguro_id',$Seguro->id)
      ->where('tipo_Asiento_id',$Asiento->tipo_Asiento_id)
      ->get()->random();
    return [

      'reservado'=> Reserva::RESERVADO,
      'estado'=> Reserva::PAGADO_TOTALMENTE,
      'pagado'=> $Precio->precio,
      'Fecha_id'=> $fecha->id,
      'Precio_id'=> $Precio->id,
      'Asiento_id'=> $Asiento->id,
      'Cliente_id'=>$cliente->id,

    ];
});
