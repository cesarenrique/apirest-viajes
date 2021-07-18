<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Cliente;

class ClienteController extends ApiController
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
     *   path="/clientes",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Clientes",
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
     *         @SWG\Items(ref="#definitions/Cliente")
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
        $clientes=Cliente::all();
        return $this->showAll($clientes);
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
     *   path="/clientes",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Create Cliente for store",
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
     *            @SWG\Property(property="nombre", type="string", example="nombre apellido"),
     *            @SWG\Property(property="email", type="string", example="nombre@gmail.com"),
     *            @SWG\Property(property="NIF", type="string", example="12345678Z"),
     *            @SWG\Property(property="telefono", type="string", example="666777888"),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Cliente")
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
        'NIF'=> 'required|min:8',
        'nombre'=> 'required|min:2',
        'email' => 'required|email',
        'telefono'=> 'required|min:8',
      ];
      $this->validate($request,$rules);
      $campos=$request->all();
      $cliente=Cliente::create($campos);
      return $this->showOne($cliente,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/clientes/{cliente_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Cliente",
     *		  @SWG\Parameter(
     *          name="cliente_id",
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
     *         @SWG\Items(ref="#definitions/Cliente")
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
        $cliente=Cliente::findOrFail($id);
        return $this->showOne($cliente);
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
     *   path="/clientes/{cliente_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Update Cliente",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="cliente_id",
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
     *            @SWG\Property(property="nombre", type="string", example="nombre apellido"),
     *            @SWG\Property(property="email", type="string", example="nombre@gmail.com"),
     *            @SWG\Property(property="NIF", type="string", example="12345678Z"),
     *            @SWG\Property(property="telefono", type="string", example="666777888"),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Cliente")
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
      $cliente=Cliente::findOrFail($id);
      $rules=[
        'NIF'=> 'min:8',
        'nombre'=> 'min:2',
        'email' => 'email',
        'telefono'=> 'min:8',
      ];
      $this->validate($request,$rules);
      if($request->has('NIF')){
          $cliente->NIF=$request->NIF;
      }
      if($request->has('nombre')){
          $cliente->nombre=$request->nombre;
      }
      if($request->has('email')){
          $cliente->email=$request->email;
      }
      if($request->has('telefono')){
          $cliente->telefono=$request->telefono;
      }
      if(!$cliente->isDirty()){
         return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
      }

      $cliente->save();

      return $this->showOne($cliente);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Delete(
     *   path="/clientes/{cliente_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Delete Cliente",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="cliente_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Cliente")
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
    public function destroy($id)
    {
      $cliente=Cliente::findOrFail($id);
      $cliente->delete();
      return $this->showOne($cliente);
    }


    public function lookforNIF(Request $request)
    {
      $rules=[
        'NIF'=> 'required|min:8'
      ];
      $this->validate($request,$rules);

      $clientes=Cliente::where('NIF',$request->NIF)->get();
      return $this->showAll($clientes);

    }
}
