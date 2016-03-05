<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuadrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuadrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('empresa');
            $table->enum('estado',['Pendiente','Validado','Completado'])->default('Pendiente');
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
        Schema::drop('cuadrantes');
    }
}
