<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Cliente;

class ClienteTransformer extends TransformerAbstract
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
    public function transform(Cliente $cliente)
    {
        return [
          'identificador' => (int)$cliente->id,
          'nif'=>(string)$cliente->NIF,
          'nombre'=>(string)$cliente->nombre,
          'correo'=>(string)$cliente->email,
          'telefono'=>(string)$cliente->telefono,
          'tipo'=>(string)$cliente->tipo_usuario,
          'fechaCreacion'=>(string)$cliente->created_at,
          'fechaActualizacion'=>(string)$cliente->updated_at,
          'fechaEliminacion'=>isset($cliente->deleted_at) ?(string)$cliente->deteted_at: null,
          'links'=>[
              [
                  'rel'=>'self',
                  'href'=> route('clientes.show',$cliente->id),
              ],
              [
                  'rel'=>'clientes.reservas',
                  'href'=> route('clientes.reservas.index',$cliente->id),
              ],
              [
                  'rel'=>'clientes.tarjetas',
                  'href'=> route('clientes.tarjetas.index',$cliente->id),
              ],
            ],
        ];
    }
}
