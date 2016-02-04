<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('seccion')->nullable();
            $table->string('restaurante');
            $table->enum('estado', ['Pendiente','Cerrado'])->default('Pendiente');
            $table->string('descripcion');
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
        Schema::drop('inventarios');
    }
}
