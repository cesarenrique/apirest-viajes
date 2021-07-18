<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Tarjeta;
use App\Reserva;
use App\Transformers\ClienteTransformer;

class Cliente extends Model
{
    use SoftDeletes;
    public $transformer= ClienteTransformer::class;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'NIF','nombre', 'email', 'telefono',
    ];
    public function tarjetas(){
        return $this->hasMany(Tarjeta::class);
    }

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
