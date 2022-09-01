<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mark');
            $table->string('model');
            $table->integer('year');
            $table->integer('run');
            $table->string('color')->nullable();
            $table->string('body-type');
            $table->string('engine-type');
            $table->string('transmission');
            $table->string('gear-type');
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->foreign('generation_id')->references('id')->on('generations');
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
        Schema::dropIfExists('autos');
    }
};
