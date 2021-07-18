<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Reserva;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reservado');
            $table->string('estado');
            $table->string('pagado');
            $table->bigInteger('Fecha_id')->unsigned();
            $table->bigInteger('Precio_id')->unsigned();
            $table->bigInteger('Asiento_id')->unsigned();
            $table->bigInteger('Cliente_id')->unsigned()->nullable();
            $table->foreign('Fecha_id')->references('id')->on('fechas');
            $table->foreign('Precio_id')->references('id')->on('precios');
            $table->foreign('Asiento_id')->references('id')->on('asientos');
            $table->foreign('Cliente_id')->references('id')->on('clientes');
            $table->unique(['Fecha_id','Asiento_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
