<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Trayecto;

class TrayectoTransformer extends TransformerAbstract
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
    public function transform(Trayecto $Trayecto)
    {
        return [
          'identificador'=>(int)$Trayecto->id,
          'NIF'=>(string)$Trayecto->NIF,
          'empresa'=> (string)$Trayecto->empresa,
          'LocalidadIdentificador'=>(int)$Trayecto->Localidad_id,
          'fechaCreacion'=>(string)$Trayecto->created_at,
          'fechaActualizacion'=>(string)$Trayecto->updated_at,
          'fechaEliminacion'=>isset($Trayecto->deleted_at) ?(string)$Trayecto->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('trayectos.show',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.precios',
                  'href'=> route('trayectos.precios.index',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.fechas',
                  'href'=> route('trayectos.fechas.index',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.asientos',
                  'href'=> route('trayectos.asientos.index',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.seguros',
                  'href'=> route('trayectos.seguros.index',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.reservas',
                  'href'=> route('trayectos.reservas.index',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.tipo_habitacions',
                  'href'=> route('trayectos.tipo_asientos.index',$Trayecto->id),
              ],
              [
                  'rel'=>'trayectos.precios.generar',
                  'href'=> route('trayectos.precios.generar',$Trayecto->id),
              ],
          ],
        ];
    }
}
