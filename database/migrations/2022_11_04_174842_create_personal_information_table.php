<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_gender');
            $table->unsignedInteger('id_birth_municipality');
            $table->unsignedInteger('id_residence_municipality');
            $table->unsignedInteger('id_stratum');
            $table->unsignedInteger('id_school');
            $table->date('birth_date');
            $table->integer('year_of_degree');
            $table->timestamps();
            $table->foreign('id_gender')->references('id')->on('gender');
            $table->foreign('id_birth_municipality')->references('id')->on('municipality');
            $table->foreign('id_residence_municipality')->references('id')->on('municipality');
            $table->foreign('id_stratum')->references('id')->on('stratum');
            $table->foreign('id_school')->references('id')->on('school');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_information');
    }
}
