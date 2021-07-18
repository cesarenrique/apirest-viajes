<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Fecha;

class FechaTransformer extends TransformerAbstract
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
    public function transform(Fecha $fecha)
    {
        return [
          'identificador'=>(int)$fecha->id,
          'fecha'=> (string)$fecha->abierto,
          'HotelIdentificador'=>(int)$fecha->Hotel_id,
          'fechaCreacion'=>(string)$fecha->created_at,
          'fechaActualizacion'=>(string)$fecha->updated_at,
          'fechaEliminacion'=>isset($fecha->deleted_at) ?(string)$fecha->deteted_at: null,
          
        ];
    }
}
