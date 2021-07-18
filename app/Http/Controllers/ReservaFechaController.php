<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Reserva;
use App\Fecha;
use App\Alojamiento;
use App\Habitacion;
use App\Pension;
use App\Temporada;
use App\Http\Controllers\TemporadaController;
use Illuminate\Support\Collection;

class ReservaFechaController extends ApiController
{
    public function __construct(){
      $this->middleware('client.credentials');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      $rules=[
        'fecha_desde'=> 'required',
        'fecha_hasta'=> 'required',
        'Pension_id' => 'required',
        'Habitacion_id'=> 'required|exists:habitacions,id',
        'Cliente_id'=> 'required|exists:clientes,id',
        'Tarjeta' => "min:15",
      ];
      $this->validate($request,$rules);

      $habitacion=Habitacion::findOrFail($request->Habitacion_id);
      if($this->puedeReservarseValidar($habitacion->Hotel_id,$request->fecha_desde,$request->fecha_hasta)){
          $fechas=Fecha::whereBetween('abierto',[$request->fecha_desde,$request->fecha_hasta])->where('Hotel_id',$habitacion->Hotel_id)->get();
          $collection=new Collection();

          foreach ($fechas as $fecha) {
            $campos=array();
            $campos['reservado']=Reserva::PRERESERVADO;
            $campos['estado']=RESERVA::PENDIENTE_PAGO;
            $campos['Habitacion_id']=$habitacion->id;
            $campos['Cliente_id']=$request->Cliente_id;
            $campos['pagado']='0';
            $temporada=Temporada::where('Hotel_id',$habitacion->Hotel_id)->where('fecha_desde','<=',$fecha->abierto)->where('fecha_hasta','>=',$fecha->abierto)->firstOrFail();
            $alojamiento=Alojamiento::where('tipo_habitacion_id',$habitacion->tipo_habitacion_id)
            ->where('Temporada_id',$temporada->id)->where('Pension_id',$request->Pension_id)->firstOrFail();
            $campos['Temporada_id']=$temporada->id;
            $campos['Alojamiento_id']=$alojamiento->id;
            $campos['Fecha_id']=$fecha->id;

            DB::transaction(function () use($campos) {
                Reserva::create($campos);

            });
            $reserva=Reserva::where('Cliente_id',$request->Cliente_id)
             ->where('Alojamiento_id',$alojamiento->id)
             ->where('Habitacion_id',$habitacion->id)
             ->where('Fecha_id',$fecha->id)->firstOrFail();
             $collection->push($reserva);

          }
          return $this->showAll($collection,201);

      }

      return $this->errorResponse("fechas de la reserva no son consecutivas hay dias cerrados o temporadas sin registrar en medio",404);
      /*
      $campos=$request->all();
      $campos['reservado']=Reserva::RESERVADO;
      $campos['estado']=RESERVA::PAGADO_TOTALMENTE;

      $fecha=Fecha::findOrFail($request->Fecha_id);
      $habitacion=Habitacion::findOrFail($request->Habitacion_id);
      $alojamiento=Alojamiento::findOrFail($request->Alojamiento_id);
      $pension=Pension::findOrFail($alojamiento->Pension_id);
      if(!($fecha->Hotel_id==$habitacion->Hotel_id && $fecha->Hotel_id==$pension->Hotel_id)){
        return $this->errorResponse('Fecha_id, Habitacion_id, Alojamiento_id deben ser del mismo hotel',405);
      }

      $campos['pagado']=$alojamiento->precio;

      DB::transaction(function () use($campos) {
          Reserva::create($campos);

      });
      $reserva_previo=Reserva::where('Cliente_id',$request->Cliente_id)
       ->where('Alojamiento_id',$request->Alojamiento_id)
       ->where('Habitacion_id',$request->Habitacion_id)
       ->where('Fecha_id',$request->Fecha_id)->get();

       if($reserva_previo->isEmpty()){
         return errorResponse("Reserva no encontrada",405);
       }
       $reserva=$reserva_previo->first();
       return $this->showOne($reserva,201);*/
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
}
