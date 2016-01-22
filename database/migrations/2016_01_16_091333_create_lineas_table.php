<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pedido_id');
            $table->integer('article_id');
            $table->decimal('precio',5,2)->nullable();
            $table->decimal('cantidad',5,2)->nullable();
            $table->boolean('recibido')->default(false);
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
        Schema::drop('lineas');
    }
}
