<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'nombre'=>(string)$user->name,
            'correo'=>(string)$user->email,
            'esVerificado'=>(string)$user->verified,
            'tipo'=>(string)$user->tipo_usuario,
            'fechaCreacion'=>(string)$user->created_at,
            'fechaActualizacion'=>(string)$user->updated_at,
            'fechaEliminacion'=>isset($user->deleted_at) ?(string)$user->deteted_at: null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=> route('users.show',$user->id),
                ],
            ],
        ];
    }
}
