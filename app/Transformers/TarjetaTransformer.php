<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Tarjeta;
class TarjetaTransformer extends TransformerAbstract
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
    public function transform(Tarjeta $tarjeta)
    {
        return [
          'identificador'=>(int)$tarjeta->id,
          'numero'=> (string)$tarjeta->numero,
          'ClienteIdentificador'=>(int)$tarjeta->Cliente_id,
          'fechaCreacion'=>(string)$tarjeta->created_at,
          'fechaActualizacion'=>(string)$tarjeta->updated_at,
          'fechaEliminacion'=>isset($tarjeta->deleted_at) ?(string)$tarjeta->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('tarjetas.show',$tarjeta->id),
              ],
            ],
        ];
    }
}
