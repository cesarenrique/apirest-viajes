<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Provincia;
use App\Transformers\PaisTransformer;

class Pais extends Model
{
  use Notifiable,SoftDeletes;


  public $transformer= PaisTransformer::class;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $dates=['deleted_at'];
  protected $fillable = [
      'id',
      'nombre',
  ];

  public function provincias(){
    return $this->hasMany(Provincia::class);
  }
}
