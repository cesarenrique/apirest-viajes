<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Provincia;
use App\Trajecto;
use App\Transformers\LocalidadTransformer;

class Localidad extends Model
{
  use Notifiable,SoftDeletes;

  public $transformer= LocalidadTransformer::class;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $dates=['deleted_at'];
  protected $fillable = [
      'id',
      'nombre',
      'Provincia_id',
  ];

  public function provincia(){
    return $this->belongsTo(Provincia::class);
  }

  public function Trajectos(){
    return $this->hasMany(Trajecto::class);
  }
}
