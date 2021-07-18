<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Tarjeta;

class TarjetaController extends ApiController
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
     *   path="/tarjetas",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Tarjetas",
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
     *         @SWG\Items(ref="#definitions/Tarjeta")
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
        $tarjetas=Tarjeta::all();
        return $this->showAll($tarjetas);
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
          *   path="/tarjetas",
          *   security={
          *     {"passport": {}},
          *   },
          *   summary="Create Tarjeta for store",
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
          *            @SWG\Property(property="Cliente_id", type="integer", example=1),
          *            @SWG\Property(property="numero", type="string", example="1231331313321"),
          *          ),
          *      ),
          *   @SWG\Response(
          *      response=201,
          *      description="Create successful operation",
          *      @SWG\Schema(ref="#definitions/Tarjeta")
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
        'numero'=> 'required|min:15',
        'Cliente_id'=> 'required|exists:clientes,id',
      ];
      $this->validate($request,$rules);
      $campos=$request->all();
      $tarjeta=Tarjeta::create($campos);
      return $this->showOne($tarjeta,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/tarjetas/{tarjeta_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Tarjeta",
     *		  @SWG\Parameter(
     *          name="tarjeta_id",
     *          in="path",
     *          required=true,
     *          type="integer",
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
      $tarjeta=Cliente::findOrFail($id);
      return $this->showOne($tarjeta);
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
     *   path="/tarjetas/{tarjeta_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Update Tarjeta",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="tarjeta_id",
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
     *            @SWG\Property(property="Cliente_id", type="integer", example=1),
     *            @SWG\Property(property="numero", type="string", example="1231331313321"),
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
      $tarjeta=Cliente::findOrFail($id);
      $rules=[
        'numero'=> 'min:15',
      ];
      $this->validate($request,$rules);

      if($request->has('numero')){
          $cliente->numero=$request->numero;
      }

      if(!$tarjeta->isDirty()){
         return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
      }

      $tarjeta->save();

      return $this->showOne($tarjeta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Delete(
     *   path="/tarjetas/{tarjeta_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Delete Tarjeta",
     *		  @SWG\Parameter(
     *          name="tarjeta_id",
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
      $tarjeta=Cliente::findOrFail($id);
      $tarjeta->delete();
      return $this->showOne($tarjeta);
    }
}
