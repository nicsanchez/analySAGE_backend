<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_personal_information');
            $table->unsignedInteger('id_first_option_program');
            $table->unsignedInteger('id_second_option_program');
            $table->unsignedInteger('id_registration_type');
            $table->unsignedInteger('id_semester');
            //$table->integer('id_presentation_place'); pendiente de que Augusto pregunte
            $table->unsignedInteger('id_acceptance_type')->nullable();
            $table->unsignedInteger('id_accepted_program')->nullable();
            $table->integer('credential');
            $table->dateTime('registration_date');
            $table->boolean('admitted');
            $table->integer('version');
            $table->integer('day_session');
            $table->timestamps();
            $table->foreign('id_personal_information')->references('id')->on('personal_information');
            $table->foreign('id_first_option_program')->references('id')->on('program');
            $table->foreign('id_second_option_program')->references('id')->on('program');
            $table->foreign('id_registration_type')->references('id')->on('registration_type');
            $table->foreign('id_semester')->references('id')->on('semester');
            $table->foreign('id_acceptance_type')->references('id')->on('acceptance_type');
            $table->foreign('id_accepted_program')->references('id')->on('program');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presentation');
    }
}
