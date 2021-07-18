<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Temporada;

class TemporadaTransformer extends TransformerAbstract
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
    public function transform(Temporada $temporada)
    {
        return [
          'identificador'=>(int)$temporada->id,
          'tipo'=> (string)$temporada->tipo,
          'fechaInicio'=> (string)$temporada->fecha_desde,
          'fechaFin'=> (string)$temporada->fecha_hasta,
          'HotelIdentificador'=>(int)$temporada->Hotel_id,
          'fechaCreacion'=>(string)$temporada->created_at,
          'fechaActualizacion'=>(string)$temporada->updated_at,
          'fechaEliminacion'=>isset($temporada->deleted_at) ?(string)$temporada->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('temporadas.show',$temporada->id),
              ],
            ],
        ];
    }
}
