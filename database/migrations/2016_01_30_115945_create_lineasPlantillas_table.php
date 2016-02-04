<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasPlantillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineasPlantillas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantilla_id');
            $table->integer('articulo_codint');
            $table->string('talla',10)->nullable();
            $table->string('color',10)->nullable();
            $table->float('precio')->nullable()->default(0);
            $table->float('dto')->nullable()->default(0);
            $table->float('total')->nullable()->default(0);
            $table->string('cod_barras',15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lineasPlantillas');
    }
}
