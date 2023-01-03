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
            $table->unsignedInteger('id_second_option_program')->nullable();
            $table->unsignedInteger('id_registration_type');
            $table->unsignedInteger('id_semester');
            //$table->integer('id_presentation_place'); pendiente de que Augusto pregunte
            $table->unsignedInteger('id_acceptance_type')->nullable();
            $table->unsignedInteger('id_accepted_program')->nullable();
            $table->integer('credential');
            $table->dateTime('registration_date');
            $table->boolean('admitted');
            $table->integer('version')->nullable();
            $table->integer('day_session')->nullable();
            $table->decimal('rl_score', 8, 2)->nullable();
            $table->decimal('lc_score', 8, 2)->nullable();
            $table->timestamps();
            $table->foreign('id_personal_information')->references('id')->on('personal_information');
            $table->foreign('id_first_option_program')->references('id')->on('program');
            $table->foreign('id_second_option_program')->references('id')->on('program');
            $table->foreign('id_registration_type')->references('id')->on('registration_type');
            $table->foreign('id_semester')->references('id')->on('semester');
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
