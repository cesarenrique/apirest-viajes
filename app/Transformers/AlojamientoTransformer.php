<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Alojamiento;

class AlojamientoTransformer extends TransformerAbstract
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
    public function transform(Alojamiento $alojamiento)
    {
        return [
          'identificador'=>(int)$alojamiento->id,
          'precio'=> (string)$alojamiento->precio,
          'PensionIdentificador'=>(int)$alojamiento->Pension_id,
          'TipoHabitacionIdentificador'=>(int)$alojamiento->tipo_habitacion_id,
          'TemporadaIdentificador'=>(int)$alojamiento->Temporada_id,
          'fechaCreacion'=>(string)$alojamiento->created_at,
          'fechaActualizacion'=>(string)$alojamiento->updated_at,
          'fechaEliminacion'=>isset($alojamiento->deleted_at) ?(string)$alojamiento->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('alojamientos.show',$alojamiento->id),
              ],
              [
                  'rel'=>'alojamientos.hotels',
                  'href'=> route('alojamientos.hotels.index',$alojamiento->id),
              ],
              [
                  'rel'=>'alojamientos.habitacions',
                  'href'=> route('alojamientos.habitacions.index',$alojamiento->id),
              ],
            ],
        ];
    }
}
