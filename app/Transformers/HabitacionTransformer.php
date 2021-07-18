<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Habitacion;

class HabitacionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Habitacion $habitacion)
    {
        return [
          'identificador'=>(int)$habitacion->id,
          'numero'=> (string)$habitacion->numero,
          'HotelIdentificador'=>(int)$habitacion->Hotel_id,
          'fechaCreacion'=>(string)$habitacion->created_at,
          'fechaActualizacion'=>(string)$habitacion->updated_at,
          'fechaEliminacion'=>isset($habitacion->deleted_at) ?(string)$habitacion->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('habitacions.show',$habitacion->id),
              ],

              [
                  'rel'=>'habitacions.alojamientos',
                  'href'=> route('habitacions.alojamientos.index',$habitacion->id),
              ],
              [
                  'rel'=>'habitacions.fechas',
                  'href'=> route('habitacions.fechas.index',$habitacion->id),
              ],
              [
                  'rel'=>'habitacions.reservas',
                  'href'=> route('habitacions.reservas.index',$habitacion->id),
              ],
            ],
        ];
    }
}
