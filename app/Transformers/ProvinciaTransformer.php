<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Provincia;

class ProvinciaTransformer extends TransformerAbstract
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
    public function transform(Provincia $provincia)
    {
        return [
          'identificador'=>(int)$provincia->id,
          'nombre'=> (string)$provincia->nombre,
          'PaisIdentificador'=>(int)$provincia->Pais_id,
          'fechaCreacion'=>(string)$provincia->created_at,
          'fechaActualizacion'=>(string)$provincia->updated_at,
          'fechaEliminacion'=>isset($provincia->deleted_at) ?(string)$provincia->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('provincias.show',$provincia->id),
              ],
              [
                  'rel'=>'pais.hotels',
                  'href'=> route('provincias.hotels.index',$provincia->id),
              ],
              [
                  'rel'=>'provincias.localidads',
                  'href'=> route('provincias.localidads.index',$provincia->id),
              ],
          ],
        ];
    }
}
