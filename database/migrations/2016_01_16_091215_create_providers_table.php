<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo_interno')->nullable();
            $table->string('nombre');
            $table->string('razon_social')->nullable();
            $table->string('contacto')->nullable();
            $table->string('tel_contacto')->nullable();
            $table->text('comentarios')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('providers');
    }
}
