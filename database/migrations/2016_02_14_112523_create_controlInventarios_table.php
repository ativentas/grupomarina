<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controlInventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurante');
            $table->integer('inicial_id');
            $table->integer('final_id');
            $table->date('final_fecha');
            $table->string('descripcion');
            $table->decimal('promedio',4,2)->nullable();
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
        Schema::drop('controlInventarios');
    }
}
