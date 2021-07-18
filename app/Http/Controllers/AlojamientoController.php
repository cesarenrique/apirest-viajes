<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Alojamiento;
use Illuminate\Support\Facades\DB;
use App\Hotel;
use Illuminate\Support\Collection;

class AlojamientoController extends ApiController
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
     *   path="/alojamientos",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Alojamientos",
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
     *   @SWG\Response(response=500, description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors500")
     *   ),
     *)
     *
     **/
    public function index()
    {
        $alojamientos=Alojamiento::all();
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

     /**
     * @SWG\Get(
     *   path="/alojamientos/{alojamiento_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Show one Alojamiento",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="alojamiento_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
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
    public function show($id)
    {
        $alojamiento=Alojamiento::findOrFail($id);
        return $this->showOne($alojamiento);
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
     /**
     * @SWG\Put(
     *   path="/alojamientos/{alojamiento_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Update Alojamientos",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="alojamiento_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *		  @SWG\Parameter(
     *          name="data",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *            @SWG\Property(property="precio", type="string", example="299.99"),
     *          ),
     *      ),
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
    public function update(Request $request, $id)
    {
      $alojamiento=Alojamiento::findOrFail($id);
      $rules=[
        'precio'=> 'required',
      ];

      $this->validate($request,$rules);

      if($request->has('precio')){
          if(!(preg_match_all('/^[0-9]+([,][0-9]+)?$/',$request->precio))){
             return $this->errorResponse("el precio tiene que ser formato float",401);
          }
          $alojamiento->precio=$request->precio;
      }


      if(!$alojamiento->isDirty()){
         return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
      }

      $alojamiento->save();
      return $this->showOne($alojamiento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Delete(
     *   path="/alojamientos/{alojamiento_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Delete Alojamientos",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="alojamiento_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
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
    public function destroy($id)
    {
      $alojamiento=Alojamiento::findOrFail($id);
      $alojamiento->delete();
      return $this->showOne($alojamiento);
    }
    public function descriptivo($alojamiento_id){

       $alojamiento=Alojamiento::findOrFail($alojamiento_id);
       $alojamientos=DB::select("select a.id 'identificador', precio 'precio', p2.tipo 'pension',
          th.tipo 'tipoHabitacion', t.tipo 'temporada', t.fecha_desde, t.fecha_hasta
          from alojamientos a, pensions p2 ,tipo_habitacions th ,temporadas t
          where  p2.Hotel_id=th.Hotel_id  and p2.Hotel_id =t.Hotel_id
          and a.Pension_id =p2.id
          and a.tipo_habitacion_id =th.id and t.id =a.Temporada_id
          and a.id =".$alojamiento->id );
       $collection = new Collection();
       foreach($alojamientos as $alojamiento){
          $collection->push($alojamiento);
       }
       return $this->showOne2($collection->first());
     }

}
