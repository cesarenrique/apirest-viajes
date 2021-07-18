<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Pais;

class PaisTransformer extends TransformerAbstract
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
    public function transform(Pais $pais)
    {
        return [
          'identificador'=>(int)$pais->id,
          'nombre'=> (string)$pais->nombre,
          'fechaCreacion'=>(string)$pais->created_at,
          'fechaActualizacion'=>(string)$pais->updated_at,
          'fechaEliminacion'=>isset($pais->deleted_at) ?(string)$pais->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('pais.show',$pais->id),
              ],
              [
                  'rel'=>'pais.hotels',
                  'href'=> route('pais.hotels.index',$pais->id),
              ],
              [
                  'rel'=>'pais.provincias',
                  'href'=> route('pais.provincias.index',$pais->id),
              ],
          ],
        ];
    }
}
