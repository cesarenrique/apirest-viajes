<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Hotel;

class HotelTransformer extends TransformerAbstract
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
    public function transform(Hotel $hotel)
    {
        return [
          'identificador'=>(int)$hotel->id,
          'NIF'=>(string)$hotel->NIF,
          'nombre'=> (string)$hotel->nombre,
          'LocalidadIdentificador'=>(int)$hotel->Localidad_id,
          'fechaCreacion'=>(string)$hotel->created_at,
          'fechaActualizacion'=>(string)$hotel->updated_at,
          'fechaEliminacion'=>isset($hotel->deleted_at) ?(string)$hotel->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('hotels.show',$hotel->id),
              ],
              [
                  'rel'=>'hotels.alojamientos',
                  'href'=> route('hotels.alojamientos.index',$hotel->id),
              ],
              [
                  'rel'=>'hotels.fechas',
                  'href'=> route('hotels.fechas.index',$hotel->id),
              ],
              [
                  'rel'=>'hotels.habitacions',
                  'href'=> route('hotels.habitacions.index',$hotel->id),
              ],
              [
                  'rel'=>'hotels.pensions',
                  'href'=> route('hotels.pensions.index',$hotel->id),
              ],
              [
                  'rel'=>'hotels.reservas',
                  'href'=> route('hotels.reservas.index',$hotel->id),
              ],
              [
                  'rel'=>'hotels.tipo_habitacions',
                  'href'=> route('hotels.tipo_habitacions.index',$hotel->id),
              ],
              [
                  'rel'=>'hotels.alojamientos.generar',
                  'href'=> route('hotels.alojamientos.generar',$hotel->id),
              ],
          ],
        ];
    }
}
