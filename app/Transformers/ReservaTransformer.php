<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Reserva;

class ReservaTransformer extends TransformerAbstract
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
    public function transform(Reserva $reserva)
    {
        return [
          'identificador'=>(int)$reserva->id,
          'reservado'=> (string)$reserva->reservado,
          'estado'=> (string)$reserva->estado,
          'pagado'=>(string)$reserva->pagado,
          'AlojamientoIdentificador'=>(int)$reserva->Alojamiento_id,
          'HabitacionIdentificador'=>(int)$reserva->Habitacion_id,
          'FechaIdentificador'=>(int)$reserva->Fecha_id,
          'ClienteIdentificador'=> (int)$reserva->Cliente_id,
          'fechaCreacion'=>(string)$reserva->created_at,
          'fechaActualizacion'=>(string)$reserva->updated_at,
          'fechaEliminacion'=>isset($reserva->deleted_at) ?(string)$reserva->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('reservas.show',$reserva->id),
              ],
            ],
        ];
    }
}
