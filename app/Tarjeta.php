<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\TarjetaTransformer;

class Tarjeta extends Model
{
    use SoftDeletes;
    public $transformer= TarjetaTransformer::class;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'id','numero', 'Cliente_id',
    ];
}
