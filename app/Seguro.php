<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\SeguroTransformer;

class Seguro extends Model
{
    use SoftDeletes;
    //
    const SOLO_ALOJAMIENTO="solo alojamiento";
    const SEGURO_DESAYUNO="solo desayuno";
    const SEGURO_COMPLETA="desayuno y comida";
    const SEGURO_COMPLETA_CENA="desayuno, comida y cena";

    public $transformer= SeguroTransformer::class;
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

    public function precios(){
        return $this->hasMany(Precio::class);
    }


}
