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
    const ASIENTO_SIMPLE="simple";
    const ASIENTO_DOBLE="doble";
    const ASIENTO_MATRIMONIAL="matrimonial";
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

    public function Asientos(){
      return $this->hasMany(Asiento::class);
    }

    public function Precios(){
      return $this->hasMany(Precio::class);
    }
}
