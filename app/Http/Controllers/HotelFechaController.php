<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use App\Hotel;
use DateTime;

class HotelFechaController extends ApiController
{

  public function __construct(){
    $this->middleware('client.credentials');

  }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/hotels/{hotel_id}/fechas",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Hoteles table fechas",
     *		  @SWG\Parameter(
     *          name="hotel_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
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
    public function index(Hotel $hotel)
    {
        $fechas=$hotel->fechas;
        return $this->showAll($fechas);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function abrir(Request $request,$id)
    {
        $hotel=Hotel::findOrFail($id);
        $rules=[
          'fecha_desde'=> 'required',
          'dias'=> 'required',
        ];

        $this->validate($request,$rules);
        $fecha_desde=(string)$request->fecha_desde;
        if(!(preg_match_all('/^(\d{4})(-)(0[1-9]|1[0-2])(-)([0-2][0-9]|3[0-1])$/',$fecha_desde))){
           return $this->errorResponse("la fecha tiene que ser formato yyyy-MM-dd y una fecha valida",401);
        }

        $dias=(string)$request->dias;
        if(!(preg_match_all('/^\d{1,3}$/',$dias))){
           return $this->errorResponse("el numero dias no puede ser superior a 1000",401);
        }

        $start_date = $fecha_desde;
        $tam=intval($dias);
        $fecha = DateTime::createFromFormat('Y-m-d',$start_date);
        for($i=0;$i<$tam;$i++){

          $cantidad=DB::select("select count(*) as 'cantidad' from fechas a where a.abierto='".date_format($fecha,'Y-m-d')."' and a.Hotel_id=".$hotel->id);

          if($cantidad[0]->cantidad==0){
              DB::statement(' Insert into fechas (abierto,Hotel_id) values ("'.date_format($fecha,'Y-m-d').'",'.$hotel->id.')');

          }
          $fecha->modify('+1 day');
        }
        return response()->json(['data'=>'dias que hotel esta abierto actualizada'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cerrar(Request $request,$id)
    {
        $hotel=Hotel::findOrFail($id);
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
        DB::statement("delete from fechas f where f.Hotel_id=".$hotel->id." and  '".$fecha_desde."'<=f.abierto and f.abierto<='". $fecha_hasta. "'");
        return response()->json(['data'=>'dias que hotel esta cerrado actualizada'],200);
    }
}
