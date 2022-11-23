<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BulkHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_semester');
            $table->boolean('inscribed')->default(0);
            $table->boolean('questions')->default(0);
            $table->boolean('answers')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_history');
    }
}
