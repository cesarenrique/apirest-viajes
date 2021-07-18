<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('Seguro_id')->unsigned();
            $table->bigInteger('tipo_asiento_id')->unsigned();
            $table->bigInteger('Temporada_id')->unsigned();
            $table->unique(['Seguro_id','tipo_asiento_id','Temporada_id']);
            $table->String('precio');
            $table->foreign('Seguro_id')->references('id')->on('seguros')->onDelete('cascade');
            $table->foreign('tipo_asiento_id')->references('id')->on('tipo_asientos')->onDelete('cascade');
            $table->foreign('Temporada_id')->references('id')->on('temporadas')->onDelete('cascade');
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
        Schema::dropIfExists('precios');
    }
}
