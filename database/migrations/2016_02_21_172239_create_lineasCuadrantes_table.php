<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasCuadrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineasCuadrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuadrante_id');
            $table->integer('empleado_id');
            $table->enum('tipo',['Normal','Partido','Libre','Vacaciones','Baja','Falta'])->default('Normal');
            $table->time('entrada')->nullable();
            $table->time('salida')->nullable();
            $table->time('entrada2')->nullable();
            $table->time('salida2')->nullable();
            $table->enum('estado',['Pendiente','Requerido','Firmado','Bloqueado'])->default('Pendiente');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('email')->nullable();
            $table->string('mensaje_id')->nullable();
            $table->string('asunto',50)->nullable();
            $table->string('fechaMensaje',50)->nullable();
            $table->text('body')->nullable();
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
        Schema::drop('lineasCuadrantes');
    }
}
