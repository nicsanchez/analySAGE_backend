<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_headquaters');
            $table->unsignedInteger('id_modality');
            $table->unsignedInteger('id_faculty');
            $table->unsignedInteger('consecutive');
            $table->string('name', 256);
            $table->timestamps();
            $table->foreign('id_headquaters')->references('id')->on('headquarters');
            $table->foreign('id_modality')->references('id')->on('modality');
            $table->foreign('id_faculty')->references('id')->on('faculty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program');
    }
}
