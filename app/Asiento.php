<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\AsientoTransformer;

class Asiento extends Model
{
    use SoftDeletes;


    public $transformer= AsientoTransformer::class;

    protected $dates=['deleted_at'];

    protected $fillable = [
        'id',
        'numero',
        'Trayecto_id',
        'tipo_Asiento_id',

    ];

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }

}
