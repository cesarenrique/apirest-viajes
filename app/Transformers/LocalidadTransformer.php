<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Localidad;
class LocalidadTransformer extends TransformerAbstract
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
    public function transform(Localidad $localidad)
    {
        return [
          'identificador'=>(int)$localidad->id,
          'nombre'=> (string)$localidad->nombre,
          'ProvinciaIdentificador'=>(int)$localidad->Provincia_id,
          'fechaCreacion'=>(string)$localidad->created_at,
          'fechaActualizacion'=>(string)$localidad->updated_at,
          'fechaEliminacion'=>isset($localidad->deleted_at) ?(string)$localidad->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('localidads.show',$localidad->id),
              ],
              [
                  'rel'=>'localidads.trayectos',
                  'href'=> route('localidads.trayectos.index',$localidad->id),
              ],
              [
                  'rel'=>'localidads.trayectos.descriptivo',
                  'href'=> route('localidads.trayectos.descriptivo',$localidad->id),
              ],

            ],
        ];
    }
}
