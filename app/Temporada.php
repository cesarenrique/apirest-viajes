<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\TemporadaTransformer;
class Temporada extends Model
{

  use SoftDeletes;
  //Basicas
  const TEMPORADA_BAJA="baja";
  const TEMPORADA_MEDIA="media";
  const TEMPORADA_ALTA="alta";
  const INICIAL1='2021-01-01';
  const INICIAL2='2021-03-01';
  const INICIAL3='2021-06-01';
  const INICIAL4='2021-09-01';
  const FIN='2021-12-31';

  public $transformer= TemporadaTransformer::class;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $dates=['deleted_at'];
  protected $fillable = [
    'tipo',
    'fecha_desde',
    'fecha_hasta',
    'Trajecto_id',
  ];
}
