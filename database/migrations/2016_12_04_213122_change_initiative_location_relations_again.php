<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInitiativeLocationRelationsAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['initiative_id']);
            $table->dropColumn('initiative_id');
        });
        
        Schema::create('initiative_location', function (Blueprint $table) {
            $table->integer('initiative_id')->unsigned()->index();
            $table->foreign('initiative_id')->references('id')->on('initiatives')->onDelete('cascade');

            $table->integer('location_id')->unsigned()->index();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
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
        Schema::table('locations', function (Blueprint $table) {
            $table->integer('initiative_id')->unsigned()->nullable();
            $table->foreign('initiative_id')->references('id')->on('initiatives')->onDelete('cascade');
        });

        Schema::drop('initiative_location');
    }
}
