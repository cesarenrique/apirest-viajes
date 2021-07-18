<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Habitacion;
use App\Hotel;
use Carbon\Carbon;

class HabitacionFechasController extends ApiController
{

    public function __construct(){
      $this->middleware('client.credentials');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     **/


          /**
          * @SWG\Get(
          *   path="/habitacions/{habitacion_id}/fechas",
          *   security={
          *     {"passport": {}},
          *   },
          *   summary="Get Habitacion table All Fechas",
          *     @SWG\Parameter(
          *         name="Autorization",
          *         in="header",
          *         required=true,
          *         type="string",
          *         description="Bearer {token_access}",
          *    ),
          *		  @SWG\Parameter(
          *          name="habitacion_id",
          *          in="path",
          *          required=true,
          *          type="string",
          *          description="un numero id"
          *      ),
          *   @SWG\Response(response=200, description="successful operation",
          *     @SWG\Schema(
          *         type="array",
          *         @SWG\Items(ref="#definitions/Fecha")
          *     )
          *   ),
          *   @SWG\Response(response=403, description="Autorization Exception",
          *      @SWG\Schema(ref="#definitions/Errors403")
          *   ),
          *   @SWG\Response(response=404, description="Not Found Exception",
          *      @SWG\Schema(ref="#definitions/Errors404")
          *   ),
          *   @SWG\Response(response=500, description="internal server error",
          *      @SWG\Schema(ref="#definitions/Errors500")
          *   ),
          *)
          *
          **/

    public function index(Habitacion $habitacion)
    {
        $hotel=Hotel::findOrFail($habitacion->Hotel_id);
        $fechas=$hotel->fechas;
        $reservas=$habitacion->reservas;
        $previos=collect();

        foreach ($reservas as $reserva) {

            $previos->push($reserva->Fecha_id);

        }

        $auxiliar=$previos->collect();
        $libres=collect();
        foreach ($fechas as $fecha) {
            $existe=false;

            foreach ($auxiliar as $aux) {
              if($aux==$fecha->id){
                $existe=true;
              }
            }
            if($existe==false){
              $libres->push($fecha);
            }
        }

        return $this->showAll($libres);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * En funcion de rango dice que dias esta libre una habitacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/habitacions/{habitacion_id}/fechas/libre",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Habitacion table All Fechas",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="habitacion_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *		  @SWG\Parameter(
     *          name="fecha_desde",
     *          in="query",
     *          required=true,
     *          type="string",
     *          description="una fecha de comienzo"
     *      ),
     *		  @SWG\Parameter(
     *          name="fecha_hasta",
     *          in="query",
     *          required=true,
     *          type="string",
     *          description="una fecha de fin"
     *      ),
     *   @SWG\Response(response=200, description="successful operation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#definitions/Fecha")
     *     )
     *   ),
     *   @SWG\Response(response=403, description="Autorization Exception",
     *      @SWG\Schema(ref="#definitions/Errors403")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors404")
     *   ),
     *   @SWG\Response(response=500, description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors500")
     *   ),
     *)
     *
     **/
    public function libre(Request $request,$id)
    {
      $habitacion=Habitacion::findOrFail($id);
      $rules=[
        'fecha_desde'=> 'required',
        'fecha_hasta'=> 'required',
      ];

      $this->validate($request,$rules);
      $fecha_desde=(string)$request->fecha_desde;
      if(!(preg_match_all('/^(\d{4})(-)(0[1-9]|1[0-2])(-)([0-2][0-9]|3[0-1])$/',$fecha_desde))){
         return $this->errorResponse("la fecha tiene que ser formato yyyy-MM-dd y una fecha valida",401);
      }

      $fecha_hasta=(string)$request->fecha_hasta;
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

      $hotel=Hotel::findOrFail($habitacion->Hotel_id);
      $fechas=$hotel->fechas->whereBetween('abierto',[$fecha_desde,$fecha_hasta]);
      $reservas=$habitacion->reservas;
      $previos=collect();

      foreach ($reservas as $reserva) {

          $previos->push($reserva->Fecha_id);

      }

      $auxiliar=$previos->collect();
      $libres=collect();
      foreach ($fechas as $fecha) {
          $existe=false;

          foreach ($auxiliar as $aux) {
            if($aux==$fecha->id){
              $existe=true;
            }
          }
          if($existe==false){
            $libres->push($fecha);
          }
      }

      return $this->showAll($libres);

    }

    /**
     * En funcion de rango dice que dias esta libre una habitacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/habitacions/{habitacion_id}/fechas/ocupado",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Habitacion table All Fechas",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="habitacion_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *		  @SWG\Parameter(
     *          name="fecha_desde",
     *          in="query",
     *          required=true,
     *          type="string",
     *          description="una fecha de comienzo"
     *      ),
     *		  @SWG\Parameter(
     *          name="fecha_hasta",
     *          in="query",
     *          required=true,
     *          type="string",
     *          description="una fecha de fin"
     *      ),
     *   @SWG\Response(response=200, description="successful operation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#definitions/Fecha")
     *     )
     *   ),
     *   @SWG\Response(response=403, description="Autorization Exception",
     *      @SWG\Schema(ref="#definitions/Errors403")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors404")
     *   ),
     *   @SWG\Response(response=500, description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors500")
     *   ),
     *)
     *
     **/
    public function ocupado(Request $request,$id)
    {
      $habitacion=Habitacion::findOrFail($id);
      $rules=[
        'fecha_desde'=> 'required',
        'fecha_hasta'=> 'required',
      ];

      $this->validate($request,$rules);
      $fecha_desde=(string)$request->fecha_desde;
      if(!(preg_match_all('/^(\d{4})(-)(0[1-9]|1[0-2])(-)([0-2][0-9]|3[0-1])$/',$fecha_desde))){
         return $this->errorResponse("la fecha tiene que ser formato yyyy-MM-dd y una fecha valida",401);
      }

      $fecha_hasta=(string)$request->fecha_hasta;
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

      $hotel=Hotel::findOrFail($habitacion->Hotel_id);
      $fechas=$hotel->fechas->whereBetween('abierto',[$fecha_desde,$fecha_hasta]);
      $reservas=$habitacion->reservas;
      $previos=collect();

      foreach ($reservas as $reserva) {

          $previos->push($reserva->Fecha_id);

      }

      $auxiliar=$previos->collect();
      $ocupado=collect();
      foreach ($fechas as $fecha) {
          $existe=false;

          foreach ($auxiliar as $aux) {
            if($aux==$fecha->id){
              $existe=true;
            }
          }
          if($existe==true){
            $ocupado->push($fecha);
          }
      }

      return $this->showAll($ocupado);

    }
}
