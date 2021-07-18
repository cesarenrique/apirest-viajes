<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Seguro;
use App\TipoAsiento;
use App\Transformers\TrajectoTransformer;

class Trayecto extends Model
{
    use SoftDeletes;

    public $transformer= TrayectoTransformer::class;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'NIF', 'nombre', 'Localidad_id', 'Localidad_destino_id',
      ];

    public function seguros(){
        return $this->hasMany(Seguro::class);
    }

    public function tipo_asientos(){
        return $this->hasMany(TipoAsiento::class);
    }

    public function asientos(){
        return $this->hasMany(Asiento::class);
    }

    public function fechas(){
        return $this->hasMany(Fecha::class);
    }

    public function temporadas(){
        return $this->hasMany(Temporada::class);
    }
}
