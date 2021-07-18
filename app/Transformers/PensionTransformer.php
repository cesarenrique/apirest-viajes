<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Pension;
class PensionTransformer extends TransformerAbstract
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
    public function transform(Pension $pension)
    {
        return [
          'identificador'=>(int)$pension->id,
          'tipo'=> (string)$pension->tipo,
          'HotelIdentificador'=>(int)$pension->Hotel_id,
          'fechaCreacion'=>(string)$pension->created_at,
          'fechaActualizacion'=>(string)$pension->updated_at,
          'fechaEliminacion'=>isset($pension->deleted_at) ?(string)$pension->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('pensions.show',$pension->id),
              ],
            ],
        ];
    }
}
