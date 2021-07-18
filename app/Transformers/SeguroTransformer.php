<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Seguro;
class SeguroTransformer extends TransformerAbstract
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
    public function transform(Seguro $Seguro)
    {
        return [
          'identificador'=>(int)$Seguro->id,
          'tipo'=> (string)$Seguro->tipo,
          'TrayectoIdentificador'=>(int)$Seguro->Hotel_id,
          'fechaCreacion'=>(string)$Seguro->created_at,
          'fechaActualizacion'=>(string)$Seguro->updated_at,
          'fechaEliminacion'=>isset($Seguro->deleted_at) ?(string)$Seguro->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('seguros.show',$Seguro->id),
              ],
            ],
        ];
    }
}
