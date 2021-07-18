<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use App\Hotel;
use App\Alojamiento;
use Illuminate\Support\Collection;

class HotelAlojamientoController extends ApiController
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
     *   path="/hotels/{hotel_id}/alojamientos",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Hoteles table Alojamientos",
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
     *         @SWG\Items(ref="#definitions/Alojamiento")
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
    public function index($Hotel_id)
    {
      $hotel=Hotel::findOrFail($Hotel_id);
      $pensiones=$hotel->pensions;
      $previo=collect();
      foreach($pensiones as $pension){
        $previo->push($pension->alojamientos);
      }
      $alojamientos=$previo->collapse();
      return $this->showAll($alojamientos);
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
     * Genera tabla de precios
     *
     * @return \Illuminate\Http\Response
     */
    public function generar($Hotel_id)
    {
        $hotel=Hotel::findOrFail($Hotel_id);
        $alojamientos=DB::select("select p.id 'Pension_id',th.id 'tipo_habitacion_id',t.id 'Temporada_id', p.Hotel_id
            from pensions p, tipo_habitacions th, temporadas t
              where p.Hotel_id =t.Hotel_id and th.Hotel_id=t.Hotel_id and p.Hotel_id =th.Hotel_id  and p.Hotel_id=".$hotel->id);



        foreach ($alojamientos as $alojamiento) {
            $cantidad=DB::select("select count(*) as 'cantidad' from alojamientos a where a.Pension_id=".$alojamiento->Pension_id." and a.tipo_habitacion_id=".$alojamiento->tipo_habitacion_id." and a.Temporada_id=".$alojamiento->Temporada_id." and a.deleted_at is null");

            if($cantidad[0]->cantidad==0){
                $cantidad=DB::select("select count(*) as 'cantidad' from alojamientos a where a.Pension_id=".$alojamiento->Pension_id." and a.tipo_habitacion_id=".$alojamiento->tipo_habitacion_id." and a.Temporada_id=".$alojamiento->Temporada_id);
                $precio="99.99";
                if($cantidad[0]->cantidad==0){


                  DB::statement(' Insert into alojamientos (Pension_id,tipo_habitacion_id,Temporada_id,precio) values ('.$alojamiento->Pension_id.','.$alojamiento->tipo_habitacion_id.','.$alojamiento->Temporada_id.','.$precio.')');
                }else{
                  $cantidad=DB::select("select a.id from alojamientos a where a.Pension_id=".$alojamiento->Pension_id." and a.tipo_habitacion_id=".$alojamiento->tipo_habitacion_id." and a.Temporada_id=".$alojamiento->Temporada_id);
                  Alojamiento::withTrashed()->find($cantidad[0]->id)->restore();
                  $encontrado=Alojamiento::findOrFail($cantidad[0]->id);
                  $encontrado->precio=$precio;
                  $encontrado->save();
                }
            }
         }
         return response()->json(['data'=>'tabla precios actualizada'],200);
    }


    public function descriptivo($hotel_id){
       $hotel=Hotel::findOrFail($hotel_id);
       $alojamientos=DB::select("select a.id 'identificador', precio 'precio', p2.tipo 'pension',
          th.tipo 'tipoHabitacion', t.tipo 'temporada', t.fecha_desde, t.fecha_hasta
          from alojamientos a, pensions p2 ,tipo_habitacions th ,temporadas t
          where  p2.Hotel_id=th.Hotel_id  and p2.Hotel_id =t.Hotel_id
          and a.Pension_id =p2.id
          and a.tipo_habitacion_id =th.id and t.id =a.Temporada_id
          and p2.Hotel_id =".$hotel->id );
       $collection = new Collection();
       foreach($alojamientos as $alojamiento){
          $collection->push($alojamiento);
       }
       return $this->showAll2($collection);
    }
}
