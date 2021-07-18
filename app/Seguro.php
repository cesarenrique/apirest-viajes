<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\SeguroTransformer;

class Seguro extends Model
{
    use SoftDeletes;
    //
    const SIN_SEGURO="Sin Seguro";
    const SEGURO_VIAJE="Seguro de viaje normal";
    const SEGURO_VIAJE_PLUS="Seguro de viaje plus";

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
