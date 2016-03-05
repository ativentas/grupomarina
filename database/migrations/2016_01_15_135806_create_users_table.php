<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('nombre_completo')->nullable();
            $table->string('restaurante');
            $table->string('empresa');
            $table->time('entrada')->nullable();
            $table->time('salida')->nullable();
            $table->boolean('turno_partido')->default(false);
            $table->time('entrada2')->nullable();
            $table->time('salida2')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_supervisor')->default(false);
            $table->boolean('is_root')->default(false);
            $table->string('remember_token')->nullable();
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
        Schema::drop('users');
    }
}
