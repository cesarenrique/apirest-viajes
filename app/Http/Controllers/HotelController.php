<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Hotel;

class HotelController extends ApiController
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
     *   path="/hotets",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Hoteles",
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
     *         @SWG\Items(ref="#definitions/Hotel")
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
        $hotels=Hotel::all();

        return $this->showAll($hotels);
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
     *   path="/hotels",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Create Hotel for store",
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
     *            @SWG\Property(property="NIF", type="string", example="12345678Z"),
     *            @SWG\Property(property="Localidad_id", type="integer", example=1),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/Hotel")
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
          'Localidad_id' => 'required|exists:localidads,id',
        ];
        $this->validate($request,$rules);
        $campos=$request->all();
        $hotel=Hotel::create($campos);
        return $this->showOne($hotel,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/hotels/{hotel_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Get Hotel",
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
     *         @SWG\Items(ref="#definitions/Hotel")
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
        $hotel=Hotel::findOrFail($id);
        return $this->showOne($hotel);
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
     *   path="/hotels/{hotel_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Update hotel",
     *     @SWG\Parameter(
     *         name="Autorization",
     *         in="header",
     *         required=true,
     *         type="string",
     *         description="Bearer {token_access}",
     *    ),
     *		  @SWG\Parameter(
     *          name="hotel_id",
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
     *            @SWG\Property(property="NIF", type="string", example="12345678Z"),
     *            @SWG\Property(property="Localidad_id", type="integer", example=1),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Update successful operation",
     *      @SWG\Schema(ref="#definitions/Hotel")
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
      $hotel=Hotel::findOrFail($id);
      $rules=[
        'NIF'=> 'min:8',
        'nombre'=> 'min:2',
        'Localidad_id' => 'exists:localidads,id',
      ];
      $this->validate($request,$rules);

      if($request->has('NIF')){
          $hotel->NIF=$request->NIF;
      }

      if($request->has('nombre')){
          $hotel->nombre=$request->nombre;
      }

      if($request->has('Localidad_id')){
          $hotel->Localidad_id=$request->Localidad_id;
      }

      if(!$hotel->isDirty()){
         return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
      }

      $hotel->save();
      return $this->showOne($hotel);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Delete(
     *   path="/hotels/{hotel_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Delete hotel",
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
     *         @SWG\Items(ref="#definitions/Hotel")
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
        $hotel=Hotel::findOrFail($id);
        $hotel->delete();
        return $this->showOne($hotel);
    }
}
