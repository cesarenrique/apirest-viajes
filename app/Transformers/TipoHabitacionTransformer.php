<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\TipoHabitacion;

class TipoHabitacionTransformer extends TransformerAbstract
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
    public function transform(TipoHabitacion $tipohab)
    {
        return [
          'identificador'=>(int)$tipohab->id,
          'tipo'=> (string)$tipohab->tipo,
          'HotelIdentificador'=>(int)$tipohab->Hotel_id,
          'fechaCreacion'=>(string)$tipohab->created_at,
          'fechaActualizacion'=>(string)$tipohab->updated_at,
          'fechaEliminacion'=>isset($tipohab->deleted_at) ?(string)$tipohab->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('tipo_habitacions.show',$tipohab->id),
              ],

              [
                  'rel'=>'tipo_habitacions.habitacions',
                  'href'=> route('tipo_habitacions.habitacions.index',$tipohab->id),
              ],
            ],
        ];
    }
}
