<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\ReservaTransformer;

class Reserva extends Model
{

    use SoftDeletes;

    const LIBRE='libre';
    const RESERVADO='reservado';
    const PRERESERVADO='prereservado';

    const PAGADO_TOTALMENTE="totalmente pagado";
    const PAGADO_PARCIALMENTE="parcialmente pagado";
    const PENDIENTE_PAGO="pendiente pago";


    public $transformer= ReservaTransformer::class;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'id',
        'pagado',
        'estado',
        'reservado',
        'Cliente_id',
        'Fecha_id',
        'Asiento_id',
        'Precio_id',
    ];

    public function fecha(){
        return $this->belongsTo(Fecha::class);
    }
}
