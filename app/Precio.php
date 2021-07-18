<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\PrecioTransformer;
class Precio extends Model
{
    use SoftDeletes;
    public $transformer= PrecioTransformer::class;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'id',
        'precio',
        'Seguro_id',
        'tipo_asiento_id',
        'Temporada_id',

    ];
}
