<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Asiento;

class AsientoTransformer extends TransformerAbstract
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
    public function transform(Asiento $Asiento)
    {
        return [
          'identificador'=>(int)$Asiento->id,
          'numero'=> (string)$Asiento->numero,
          'TrayectoIdentificador'=>(int)$Asiento->Hotel_id,
          'fechaCreacion'=>(string)$Asiento->created_at,
          'fechaActualizacion'=>(string)$Asiento->updated_at,
          'fechaEliminacion'=>isset($Asiento->deleted_at) ?(string)$Asiento->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('asientos.show',$Asiento->id),
              ],

              [
                  'rel'=>'Asientos.alojamientos',
                  'href'=> route('asientos.precios.index',$Asiento->id),
              ],
              [
                  'rel'=>'Asientos.fechas',
                  'href'=> route('asientos.fechas.index',$Asiento->id),
              ],
              [
                  'rel'=>'Asientos.reservas',
                  'href'=> route('asientos.reservas.index',$Asiento->id),
              ],
            ],
        ];
    }
}
