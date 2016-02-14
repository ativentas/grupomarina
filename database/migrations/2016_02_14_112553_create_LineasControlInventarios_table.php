<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasControlInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineasControlInventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('controlInventarios_id');
            $table->integer('codigoArticulo_id');
            $table->integer('inicial_uds');
            $table->integer('final_uds');
            $table->integer('teorico_uds');
            $table->integer('entradas');
            $table->integer('ventas');
            $table->integer('desviacion_uds');
            $table->integer('desviacion_percent');
            $table->nullabletimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lineasControlInventarios');
    }
}
