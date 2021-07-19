<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Reserva;
use App\Fecha;
use App\Precio;
use App\Asiento;
use App\Seguro;

class ReservaController extends ApiController
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
     *   path="/reservas",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Reservas",
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
     *         @SWG\Items(ref="#definitions/Reserva")
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
        $reservas=Reserva::all();
        return $this->showAll($reservas);
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

     /**
     * @SWG\Post(
     *   path="/reservas",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Create Reserva for store",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="data",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *            @SWG\Property(property="tipo", type="string", example="Desayuno delux"),
     *            @SWG\Property(property="Fecha_id", type="integer", example=1),
     *            @SWG\Property(property="Asiento_id", type="integer", example=1),
     *            @SWG\Property(property="Precio_id", type="integer", example=1),
     *            @SWG\Property(property="Cliente_id", type="integer", example=1),
     *            @SWG\Property(property="Tarjeta", type="string", example="1231331313321"),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Reserva")
     *   ),
     *   @SWG\Response(response=403, description="Autorization Exception",
     *      @SWG\Schema(ref="#definitions/Errors403")
     *   ),
     *   @SWG\Response(
     *      response=500,
     *      description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors500")
     *   )
     *)
     *
     **/
    public function store(Request $request)
    {
      $rules=[
        'Fecha_id'=> 'required|exists:fechas,id',
        'Asiento_id'=> 'required|exists:Asientos,id',
        'Precio_id' => 'required|exists:Precios,id',
        'Cliente_id'=> 'required|exists:clientes,id',
        'Tarjeta' => "min:15",
      ];
      $this->validate($request,$rules);
      $campos=$request->all();
      $campos['reservado']=Reserva::RESERVADO;
      $campos['estado']=RESERVA::PAGADO_TOTALMENTE;

      $fecha=Fecha::findOrFail($request->Fecha_id);
      $Asiento=Asiento::findOrFail($request->Asiento_id);
      $Precio=Precio::findOrFail($request->Precio_id);
      $Seguro=Seguro::findOrFail($Precio->Seguro_id);
      if(!($fecha->Hotel_id==$Asiento->Hotel_id && $fecha->Hotel_id==$Seguro->Hotel_id)){
        return $this->errorResponse('Fecha_id, Asiento_id, Precio_id deben ser del mismo hotel',405);
      }

      $campos['pagado']=$Precio->precio;

      DB::transaction(function () use($campos) {
          Reserva::create($campos);

      });
      $reserva_previo=Reserva::where('Cliente_id',$request->Cliente_id)
       ->where('Precio_id',$request->Precio_id)
       ->where('Asiento_id',$request->Asiento_id)
       ->where('Fecha_id',$request->Fecha_id)->get();

       if($reserva_previo->isEmpty()){
         return errorResponse("Reserva no encontrada",405);
       }
       $reserva=$reserva_previo->first();
       return $this->showOne($reserva,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Get(
     *   path="/reservas/{reserva_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Reserva",
     *		  @SWG\Parameter(
     *          name="reserva_id",
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
     *         @SWG\Items(ref="#definitions/Reserva")
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
        $reserva=Reserva::findOrFail($id);
        return $this->showOne($reserva);
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
     *   path="/reservas/{reserva_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Update Reserva",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="reserva_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *		  @SWG\Parameter(
     *          name="data",
     *          in="body",
     *          required=false,
     *          @SWG\Schema(
     *            @SWG\Property(property="tipo", type="string", example="Desayuno delux"),
     *            @SWG\Property(property="Fecha_id", type="integer", example=1),
     *            @SWG\Property(property="Asiento_id", type="integer", example=1),
     *            @SWG\Property(property="Precio_id", type="integer", example=1),
     *            @SWG\Property(property="Cliente_id", type="integer", example=1),
     *            @SWG\Property(property="Tarjeta", type="string", example="1231331313321"),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Update successful operation",
     *      @SWG\Schema(ref="#definitions/Reserva")
     *   ),
     *   @SWG\Response(response=403, description="Autorization Exception",
     *      @SWG\Schema(ref="#definitions/Errors403")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors404")
     *   ),
     *   @SWG\Response(
     *      response=500,
     *      description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors500")
     *   )
     *)
     *
     **/
    public function update(Request $request, $id)
    {
      $reserva=Reserva::findOrFail($id);
      $rules=[
        'Cliente_id'=> 'exists:clientes,id',
      ];
      $this->validate($request,$rules);

      if($request->has('Cliente_id')){
          $reserva->Cliente_id=$request->Cliente_id;
      }

      if(!$reserva->isDirty()){
         return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
      }

      $reserva->saveOrFail();

      return $this->showOne($reserva);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Delete(
     *   path="/reservas/{reserva_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Delete Reserva",
     *		  @SWG\Parameter(
     *          name="reserva_id",
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
     *         @SWG\Items(ref="#definitions/Reserva")
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
      $reserva=Reserva::findOrFail($id);
      $reserva->forceDelete();
      return $this->showOne($reserva);
    }
}
