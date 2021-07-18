<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrayectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trayectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('NIF');
            $table->string('empresa');
            $table->bigInteger('Localidad_id')->unsigned();
            $table->foreign('Localidad_id')->references('id')->on('localidads')->onDelete('cascade');
            $table->bigInteger('Localidad_destino_id')->unsigned();
            $table->foreign('Localidad_destino_id')->references('id')->on('localidads')->onDelete('cascade');
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
        Schema::dropIfExists('trayectos');
    }
}
