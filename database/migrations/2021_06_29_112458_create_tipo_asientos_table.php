<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoAsientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_asientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo');
            $table->bigInteger('Trayecto_id')->unsigned();
            $table->foreign('Trayecto_id')->references('id')->on('trayectos');
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
        Schema::dropIfExists('tipo_asientos');
    }
}
