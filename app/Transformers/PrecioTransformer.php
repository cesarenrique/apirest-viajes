<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Precio;

class PrecioTransformer extends TransformerAbstract
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
    public function transform(Precio $Precio)
    {
        return [
          'identificador'=>(int)$Precio->id,
          'precio'=> (string)$Precio->precio,
          'SeguroIdentificador'=>(int)$Precio->Seguro_id,
          'TipoAsientoIdentificador'=>(int)$Precio->tipo_asiento_id,
          'TemporadaIdentificador'=>(int)$Precio->Temporada_id,
          'fechaCreacion'=>(string)$Precio->created_at,
          'fechaActualizacion'=>(string)$Precio->updated_at,
          'fechaEliminacion'=>isset($Precio->deleted_at) ?(string)$Precio->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('precios.show',$Precio->id),
              ],
              [
                  'rel'=>'precios.trayectos',
                  'href'=> route('precios.trayectos.index',$Precio->id),
              ],
              [
                  'rel'=>'precios.asientos',
                  'href'=> route('precios.asientos.index',$Precio->id),
              ],
            ],
        ];
    }
}
