<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\TipoAsiento;

class TipoAsientoTransformer extends TransformerAbstract
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
    public function transform(TipoAsiento $tipohab)
    {
        return [
          'identificador'=>(int)$tipohab->id,
          'tipo'=> (string)$tipohab->tipo,
          'TrayectoIdentificador'=>(int)$tipohab->Hotel_id,
          'fechaCreacion'=>(string)$tipohab->created_at,
          'fechaActualizacion'=>(string)$tipohab->updated_at,
          'fechaEliminacion'=>isset($tipohab->deleted_at) ?(string)$tipohab->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('tipo_asientos.show',$tipohab->id),
              ],

              [
                  'rel'=>'tipo_asientos.asientos',
                  'href'=> route('tipo_asientos.asientos.index',$tipohab->id),
              ],
            ],
        ];
    }
}
