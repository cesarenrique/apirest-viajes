<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Temporada;
use Carbon\Carbon;
use DateTime;
use App\Hotel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @SWG\Swagger(
 *     basePath="",
 *     host=L5_SWAGGER_CONST_HOST,
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API REST Hoteles",
 *         description="API REST Hoteles",
 *         @SWG\Contact(
 *             email="cesarpozo25@gmail.com"
 *         )
 *     ),
 * 		@SWG\Definition(
 * 			definition="Alojamiento",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="precio", type="string", example="199,99"),
 * 			@SWG\Property(property="PensionIdentificador", type="integer", example=1),
 *      @SWG\Property(property="TipoHabitacionIdentificador", type="integer", example=1),
 *      @SWG\Property(property="TemporadaIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Cliente",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="NIF", type="string", example="49372889P"),
 * 			@SWG\Property(property="nombre", type="string", example="Rosa Vasquez"),
 *      @SWG\Property(property="email", type="string", example="rosa@gmail.com"),
 *      @SWG\Property(property="telefono", type="string", example="677777222"),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Fecha",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="fecha", type="string", example="2021-10-01"),
 * 			@SWG\Property(property="HotelIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Habitacion",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="numero", type="string", example="123"),
 * 			@SWG\Property(property="HotelIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Hotel",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="NIF", type="string", example="12345678Z"),
 * 			@SWG\Property(property="nombre", type="string", example="Reynods Hotel"),
 * 			@SWG\Property(property="LocalidadIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Localidad",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="nombre", type="string", example="Vitoria"),
 * 			@SWG\Property(property="ProvinciaIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Pension",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="tipo", type="string", example="Solo alojamiento"),
 * 			@SWG\Property(property="HotelIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Provincia",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="nombre", type="string", example="Vitoria"),
 * 			@SWG\Property(property="PaisIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Pais",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="nombre", type="string", example="España"),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Reserva",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="reservado", type="string", example="reservado"),
 * 			@SWG\Property(property="estado", type="string", example="pagado totalmente"),
 * 			@SWG\Property(property="pagado", type="string", example="199,99"),
 * 			@SWG\Property(property="AlojamientoIdentificador", type="integer", example=68),
 * 			@SWG\Property(property="HabitacionIdentificador", type="integer", example=627),
 *      @SWG\Property(property="FechaIdentificador", type="integer", example=20030),
 *      @SWG\Property(property="ClienteIdentificador", type="integer", example=699),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Tarjeta",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="numero", type="string", example="21412341241242"),
 *      @SWG\Property(property="ClienteIdentificador", type="integer", example=699),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Temporada",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="tipo", type="string", example="media"),
 * 			@SWG\Property(property="fechaInicio", type="string", example="2021-01-01"),
 * 			@SWG\Property(property="fechaFin", type="string", example="2021-06-01"),
 * 			@SWG\Property(property="HotelIdentificador", type="integer", example=68),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="TipoHabitacion",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="tipo", type="string", example="deluxe"),
 * 			@SWG\Property(property="HotelIdentificador", type="integer", example=1),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="User",
 * 			@SWG\Property(property="identificador", type="integer", description="UUID", example=1),
 * 			@SWG\Property(property="name", type="string", example="nombre apellido"),
 * 			@SWG\Property(property="email", type="string", example="abc@gmail.com"),
 *      @SWG\Property(property="esVerificado", type="string", example="0"),
 *      @SWG\Property(property="tipo_usuario", type="string", example="3"),
 *      @SWG\Property(property="fechaCreacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaActualizacion", type="string", example="2021-10-11"),
 *      @SWG\Property(property="fechaEliminacion", type="string", example="null")
 * 		),
 * 		@SWG\Definition(
 * 			definition="Errors",
 * 			@SWG\Property(property="data", type="string", description="mensaje", example="Error"),
 * 			@SWG\Property(property="code", type="Integer", example=404)
 *    ),
 * 		@SWG\Definition(
 * 			definition="Errors403",
 * 			@SWG\Property(property="data", type="string", description="mensaje", example="unauthenticated"),
 * 			@SWG\Property(property="code", type="Integer", example=403)
 *    ),
 * 		@SWG\Definition(
 * 			definition="Errors404",
 * 			@SWG\Property(property="data", type="string", description="mensaje", example="Not Found Exception"),
 * 			@SWG\Property(property="code", type="Integer", example=404)
 *    ),
 * 		@SWG\Definition(
 * 			definition="Errors406",
 * 			@SWG\Property(property="data", type="string", description="mensaje", example="Not Aceptable clients"),
 * 			@SWG\Property(property="code", type="Integer", example=406)
 *    ),
 * 		@SWG\Definition(
 * 			definition="Errors500",
 * 			@SWG\Property(property="data", type="string", description="mensaje", example="Error Interno"),
 * 			@SWG\Property(property="code", type="Integer", example=500)
 *    ),
 * )
 **/
class ApiController extends Controller
{
    use ApiResponse;

    public function puedeReservarseValidar($Hotel_id,$fecha_desde,$fecha_hasta){

      if(!(preg_match_all('/^(\d{4})(-)(0[1-9]|1[0-2])(-)([0-2][0-9]|3[0-1])$/',$fecha_desde))){
         return $this->errorResponse("la fecha tiene que ser formato yyyy-MM-dd y una fecha valida",401);
      }

      if(!(preg_match_all('/^(\d{4})(-)(0[1-9]|1[0-2])(-)([0-2][0-9]|3[0-1])$/',$fecha_hasta))){
         return $this->errorResponse("la fecha tiene que ser formato yyyy-MM-dd y una fecha valida",401);
      }
      $fecha_desde_porcion=explode("-",$fecha_desde);
      $fecha_hasta_porcion=explode("-",$fecha_hasta);

      $fechaDesde=Carbon::createFromDate($fecha_desde_porcion[0],$fecha_desde_porcion[1],$fecha_desde_porcion[2]);
      $fechaHasta=Carbon::createFromDate($fecha_hasta_porcion[0],$fecha_hasta_porcion[1],$fecha_hasta_porcion[2]);

      if($fechaHasta<$fechaDesde){
         return $this->errorResponse("fecha_desde no puede ser mayor fecha_hasta",404);
      }

      $hotel=Hotel::findOrFail($Hotel_id);
      $temporadas=$hotel->temporadas;
      $collection=new Collection();
      $perteneceUna=false;
      foreach ($temporadas as $temporada) {
        $fecha_inicio=$temporada->fecha_desde;
        $fecha_limite=$temporada->fecha_hasta;

        $fecha_inicio_porcion=explode("-",$fecha_inicio);
        $fecha_limite_porcion=explode("-",$fecha_limite);

        $fechaInicio=Carbon::createFromDate($fecha_inicio_porcion[0],$fecha_inicio_porcion[1],$fecha_inicio_porcion[2]);
        $fechaLimite=Carbon::createFromDate($fecha_limite_porcion[0],$fecha_limite_porcion[1],$fecha_limite_porcion[2]);

        if($fechaInicio<=$fechaDesde && $fechaHasta<=$fechaLimite){
            $perteneceUna=true;
            $collection->push($temporada);
        }
      }
      $dias=0;
      if($perteneceUna==false){

        foreach ($temporadas as $temporada) {
          $fecha_inicio=$temporada->fecha_desde;
          $fecha_limite=$temporada->fecha_hasta;

          $fecha_inicio_porcion=explode("-",$fecha_inicio);
          $fecha_limite_porcion=explode("-",$fecha_limite);

          $fechaInicio=Carbon::createFromDate($fecha_inicio_porcion[0],$fecha_inicio_porcion[1],$fecha_inicio_porcion[2]);
          $fechaLimite=Carbon::createFromDate($fecha_limite_porcion[0],$fecha_limite_porcion[1],$fecha_limite_porcion[2]);
          $diferencia=0;
          if($fechaInicio<=$fechaDesde && $fechaDesde<=$fechaLimite){
              $diferencia=$fechaDesde->diffInDays($fechaLimite->addDay());
          }
          if($fechaInicio<=$fechaHasta && $fechaHasta<=$fechaLimite){
              $diferencia=$fechaInicio->diffInDays($fechaHasta->addDay());
          }
          if($fechaDesde<=$fechaInicio && $fechaLimite<=$fechaHasta){
              $diferencia=$fechaInicio->diffInDays($fechaLimite);
          }
          $dias+=$diferencia;
        }
      }

      $start_date = $fecha_desde;
      $finish_date = $fecha_hasta;
      $tam=intval($dias);
      $fecha = DateTime::createFromFormat('Y-m-d',$start_date);
      $fecha2 = DateTime::createFromFormat('Y-m-d',$finish_date);


      $cantidad=DB::select("select count(DISTINCT a.abierto) as 'cantidad' from fechas a where a.abierto>='".date_format($fecha,'Y-m-d')."' and '".date_format($fecha2,'Y-m-d')."'>=a.abierto and a.Hotel_id=".$hotel->id);

      return $dias==$cantidad[0]->cantidad || $perteneceUna;
    }
}
