<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Asiento;
use App\TipoAsiento;

class AsientoController extends ApiController
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
     *   path="/Asientos",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Asientoes",
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
     *         @SWG\Items(ref="#definitions/Asiento")
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
        $Asiento=Asiento::all();
        return $this->showAll($Asiento);
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
     *   path="/Asientos",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Create Asiento for store",
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
     *            @SWG\Property(property="numero", type="string", example="120"),
     *            @SWG\Property(property="Trayecto_id", type="integer", example=1),
     *            @SWG\Property(property="tipo_Asientos", type="integer", example=1)
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Asiento")
     *   ),
     *   @SWG\Response(response=403, description="Autorization Exception",
     *      @SWG\Schema(ref="#definitions/Errors403")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors404")
     *   ),
     *   @SWG\Response(response=406, description="Not Aceptable",
     *      @SWG\Schema(ref="#definitions/Errors406")
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
          'numero'=> 'required',
          'Trayecto_id'=> 'required|exists:Trayectos,id',
          'tipo_asiento_id'=> 'required|exists:tipo_asientos,id',
        ];

        $this->validate($request,$rules);
        $campos=$request->all();
        $tipohab=TipoAsiento::findOrFail($request->tipo_asiento_id);
        if($tipohab->Trayecto_id!=$request->Trayecto_id){
           return $this->errorResponse('El id de Trayecto del tipo de habitación
           debe ser mismo Trayecto que se desea crear la habitación',406);
        }
        $Asiento=Asiento::create($campos);
        return $this->showOne($Asiento,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Get(
     *   path="/Asientos/{Asiento_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Asiento",
     *		  @SWG\Parameter(
     *          name="Asiento_id",
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
     *         @SWG\Items(ref="#definitions/Asiento")
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
        $Asiento=Asiento::findOrFail($id);
        return $this->showOne($Asiento);
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
     *   path="/Asientos/{Asiento_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Update Asiento",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="Asiento_id",
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
     *            @SWG\Property(property="numero", type="string", example="120"),
     *            @SWG\Property(property="Trayecto_id", type="integer", example=1),
     *            @SWG\Property(property="tipo_Asientos", type="integer", example=1),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=200,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Asiento")
     *   ),
     *   @SWG\Response(response=403, description="Autorization Exception",
     *      @SWG\Schema(ref="#definitions/Errors403")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors404")
     *   ),
     *   @SWG\Response(response=406, description="Not Aceptable",
     *      @SWG\Schema(ref="#definitions/Errors406")
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
        $Asiento=Asiento::findOrFail($id);
        $rules=[
          'Trayecto_id'=> 'exists:Trayectos,id',
          'tipo_Asientos'=> 'exists:tipo_Asientos,id',
        ];

        $this->validate($request,$rules);


        if($request->has('numero')){
          $Asiento->numero=$request->numero;
        }

        if($request->has('Trayecto_id') && $request->has('tipo_Asiento_id')){
            $tipohab=TipoAsiento::findOrFail($request->tipo_asiento_id);
            if($tipohab->Trayecto_id!=$request->Trayecto_id){
               return $this->errorResponse('El id de Trayecto del tipo de habitación debe ser mismo Trayecto que se desea crear la habitación',401);
            }
            $Asiento->Trayecto_id=$request->Trayecto_id;
            $Asiento->tipo_asiento_id=$request->tipo_asiento_id;
        }else if($request->has('Trayecto_id') && !$request->has('tipo_Asiento_id')){

            $tipohab=TipoAsiento::findOrFail($Asiento->tipo_asiento_id);
            if($tipohab->Trayecto_id!=$request->Trayecto_id){
               return $this->errorResponse('El id de Trayecto del tipo de habitación debe ser mismo Trayecto que se desea crear la habitación',401);
            }
            //este caso no pasara nunca con configuracion actual
            $Asiento->Trayecto_id=$request->Trayecto_id;
        }else if(!$request->has('Trayecto_id') && $request->has('tipo_Asiento_id')){
            $tipohab=TipoAsiento::findOrFail($request->tipo_asiento_id);
            if($tipohab->Trayecto_id!=$Asiento->Trayecto_id){
               return $this->errorResponse('El id de Trayecto del tipo de habitación debe ser mismo Trayecto que se desea crear la habitación',401);
            }
            $Asiento->tipo_Asiento_id=$request->tipo_asiento_id;
        }

        if(!$Asiento->isDirty()){
           return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
        }

        $Asiento->save();
        return $this->showOne($Asiento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Delete(
     *   path="/Asientos/{Asiento_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Delete Asiento",
     *		  @SWG\Parameter(
     *          name="Asiento_id",
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
     *         @SWG\Items(ref="#definitions/Asiento")
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
      $Asiento=Asiento::findOrFail($id);
      $Asiento->delete();
      return $this->showOne($Asiento);
    }
}
