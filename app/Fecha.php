<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\FechaTransformer;

class Fecha extends Model
{
  use SoftDeletes;
  const INICIAL='2021-01-01';

  public $transformer= FechaTransformer::class;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $dates=['deleted_at'];
  protected $fillable = [
    'abierto',
  ];

  public function fechas(){
      return $this->hasMany(Reserva::class);
  }

}
