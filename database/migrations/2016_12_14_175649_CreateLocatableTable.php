<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocatableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locatables', function (Blueprint $table) {
            $table->integer('location_id')->unsigned()->index();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            $table->integer('locatable_id')->unsigned()->index();
            $table->string('locatable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locatables');
    }
}
