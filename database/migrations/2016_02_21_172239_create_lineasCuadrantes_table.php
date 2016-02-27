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
            $table->enum('tipo',['Trabajo','Libre','Vacaciones','Baja','Falta'])->default('Trabajo');
            $table->time('horaEntradaM')->nullable();
            $table->time('horaSalidaM')->nullable();
            $table->time('horaEntradaT')->nullable();
            $table->time('horaSalidaT')->nullable();
            $table->enum('estado',['Pendiente','Requerido','Firmado'])->default('Pendiente');
            $table->string('mensaje_id')->nullable();
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
