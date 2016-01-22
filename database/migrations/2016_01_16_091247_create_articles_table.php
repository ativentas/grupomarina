<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->integer('codigo_interno')->nullable();
            $table->string('nombre');
            $table->string('nombre_largo')->nullable();
            $table->string('medida')->nullable();
            $table->decimal('precio',5,2)->nullable();
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
       Schema::drop('articles');
    }
}
