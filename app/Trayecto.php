<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Seguro;
use App\TipoHabitacion;
use App\Transformers\TrajectoTransformer;

class Trajecto extends Model
{
    use SoftDeletes;

    public $transformer= TrajectoTransformer::class;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'NIF', 'nombre', 'Localidad_id', 'Localidad_destino_id',
      ];

    public function seguros(){
        return $this->hasMany(Seguro::class);
    }

    public function tipo_habitacions(){
        return $this->hasMany(TipoHabitacion::class);
    }

    public function habitacions(){
        return $this->hasMany(Habitacion::class);
    }

    public function fechas(){
        return $this->hasMany(Fecha::class);
    }

    public function temporadas(){
        return $this->hasMany(Temporada::class);
    }
}
