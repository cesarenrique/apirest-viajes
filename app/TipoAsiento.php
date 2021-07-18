<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Asiento;
use App\Transformers\TipoAsientoTransformer;

class TipoAsiento extends Model
{
    use SoftDeletes;

    //basicos
    const ASIENTO_NORMAL="normal";
    const ASIENTO_EJECUTIVO="ejecutivo";
    const ASIENTO_TURISTA="turista";
    public $transformer= TipoAsientoTransformer::class;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $dates=['deleted_at'];
    protected $fillable = [
      'tipo',
      'Trayecto_id',
    ];

    public function asientos(){
      return $this->hasMany(Asiento::class);
    }

    public function precios(){
      return $this->hasMany(Precio::class);
    }
}
