<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->default(0);
            $table->string('name', 15);
            $table->string('title', 100);
            $table->enum('estado',['Pendiente','Confirmado'])->default('Pendiente');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->date('finalDay')->nullable();
            $table->integer('durationDays')->nullable();
            $table->timestamps();
            $table->boolean('allDay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
