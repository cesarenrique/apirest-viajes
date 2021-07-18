<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero');
            $table->bigInteger('Trayecto_id')->unsigned();
            $table->bigInteger('tipo_asiento_id')->unsigned();
            $table->foreign('Trayecto_id')->references('id')->on('trayectos')->onDelete('cascade');
            $table->foreign('tipo_asiento_id')->references('id')->on('tipo_asientos')->onDelete('cascade');
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
        Schema::dropIfExists('asientos');
    }
}
