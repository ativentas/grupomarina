<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileentries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('fecha')->nullable();
            $table->string('mes')->nullable();
            $table->string('year')->nullable();
            $table->enum('tipo', ['NOMINA','OTROS']);
            $table->string('descripcion')->nullable();
            $table->string('filename');
            $table->string('mime');
            $table->string('original_filename');
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
        Schema::table('fileentries', function (Blueprint $table) {
            Schema::drop('fileentries');
        });
    }
}
