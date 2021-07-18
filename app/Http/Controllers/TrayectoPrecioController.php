<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use App\Trayecto;
use App\Precio;
use Illuminate\Support\Collection;

class TrayectoPrecioController extends ApiController
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
     *   path="/Trayectos/{Trayecto_id}/Precios",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Trayectoes table Precios",
     *		  @SWG\Parameter(
     *          name="Trayecto_id",
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
     *         @SWG\Items(ref="#definitions/Precio")
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
    public function index($Trayecto_id)
    {
      $Trayecto=Trayecto::findOrFail($Trayecto_id);
      $Seguroes=$Trayecto->seguros;
      $previo=collect();
      foreach($Seguroes as $Seguro){
        $previo->push($Seguro->precios);
      }
      $Precios=$previo->collapse();
      return $this->showAll($Precios);
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
    public function generar($Trayecto_id)
    {
        $Trayecto=Trayecto::findOrFail($Trayecto_id);
        $Precios=DB::select("select p.id 'Seguro_id',th.id 'tipo_asiento_id',t.id 'Temporada_id', p.Trayecto_id
            from Seguros p, tipo_asientos th, temporadas t
              where p.Trayecto_id =t.Trayecto_id and th.Trayecto_id=t.Trayecto_id and p.Trayecto_id =th.Trayecto_id  and p.Trayecto_id=".$Trayecto->id);



        foreach ($Precios as $Precio) {
            $cantidad=DB::select("select count(*) as 'cantidad' from Precios a where a.Seguro_id=".$Precio->Seguro_id." and a.tipo_asiento_id=".$Precio->tipo_asiento_id." and a.Temporada_id=".$Precio->Temporada_id." and a.deleted_at is null");

            if($cantidad[0]->cantidad==0){
                $cantidad=DB::select("select count(*) as 'cantidad' from Precios a where a.Seguro_id=".$Precio->Seguro_id." and a.tipo_asiento_id=".$Precio->tipo_asiento_id." and a.Temporada_id=".$Precio->Temporada_id);
                $precio="99.99";
                if($cantidad[0]->cantidad==0){


                  DB::statement(' Insert into Precios (Seguro_id,tipo_asiento_id,Temporada_id,precio) values ('.$Precio->Seguro_id.','.$Precio->tipo_asiento_id.','.$Precio->Temporada_id.','.$precio.')');
                }else{
                  $cantidad=DB::select("select a.id from Precios a where a.Seguro_id=".$Precio->Seguro_id." and a.tipo_asiento_id=".$Precio->tipo_asiento_id." and a.Temporada_id=".$Precio->Temporada_id);
                  Precio::withTrashed()->find($cantidad[0]->id)->restore();
                  $encontrado=Precio::findOrFail($cantidad[0]->id);
                  $encontrado->precio=$precio;
                  $encontrado->save();
                }
            }
         }
         return response()->json(['data'=>'tabla precios actualizada'],200);
    }


    public function descriptivo($Trayecto_id){
       $Trayecto=Trayecto::findOrFail($Trayecto_id);
       $Precios=DB::select("select a.id 'identificador', precio 'precio', p2.tipo 'Seguro',
          th.tipo 'tipoHabitacion', t.tipo 'temporada', t.fecha_desde, t.fecha_hasta
          from Precios a, Seguros p2 ,tipo_asientos th ,temporadas t
          where  p2.Trayecto_id=th.Trayecto_id  and p2.Trayecto_id =t.Trayecto_id
          and a.Seguro_id =p2.id
          and a.tipo_asiento_id =th.id and t.id =a.Temporada_id
          and p2.Trayecto_id =".$Trayecto->id );
       $collection = new Collection();
       foreach($Precios as $Precio){
          $collection->push($Precio);
       }
       return $this->showAll2($collection);
    }
}
