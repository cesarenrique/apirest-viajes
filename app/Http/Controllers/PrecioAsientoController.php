<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Precio;
use App\TipoAsiento;
use App\Asiento;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
class PrecioAsientoController extends ApiController
{

    public function __construct(){
      $this->middleware('client.credentials');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($Precio_id)
    {
        $Precio=Precio::findOrFail($Precio_id);
        $tipo=TipoAsiento::findOrFail($Precio->tipo_asiento_id);
        $Asientoes=$tipo->asientos;
        return $this->showAll($Asientoes);
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
    public function show($id,$Asiento_id)
    {

      $Precio=Precio::findOrFail($id);
      $tipo=TipoAsiento::findOrFail($Precio->tipo_Asiento_id);
      $Asiento=Asiento::findOrFail($Asiento_id);
      if($tipo->id!=$Asiento->tipo_Asiento_id){
        return $this->errorResponse('La Asiento no se corresponde con el tipo',404);
      }
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fechas(Request $request,$Precio_id)
    {
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

        $dias=$fechaDesde->diffInDays($fechaHasta);
        $Precio=Precio::findOrFail($Precio_id);
        $tipo=TipoAsiento::findOrFail($Precio->tipo_asiento_id);
        $Asientoes=$tipo->Asientos;
        $collection=new Collection();
        foreach($Asientoes as $Asiento){
          $cantidad=DB::select("select count(f.id) 'cantidad' from fechas f,  Asientos h
           where f.Trayecto_id=h.Trayecto_id
           and f.Trayecto_id =".$Asiento->Trayecto_id." and '".$fechaDesde."'<=f.abierto
           and f.abierto<= '".$fechaHasta."' and h.id =".$Asiento->id);
           $cantidad2=DB::select("select count(f.id) 'cantidad' from fechas f , Asientos h,reservas r
           where f.Trayecto_id=h.Trayecto_id
           and f.Trayecto_id =".$Asiento->Trayecto_id." and '".$fechaDesde."'<=f.abierto and r.Asiento_id =h.id
           and f.id=r.Fecha_id
           and f.abierto<= '".$fechaHasta."' and h.id =".$Asiento->id);
          if($dias==($cantidad[0]->cantidad-$cantidad2[0]->cantidad)){
            $collection->push($Asiento);
          }
        }
        return $this->showAll($collection);
    }
}
