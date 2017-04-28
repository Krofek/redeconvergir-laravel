<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInitiativeAudienceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audience', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->timestamps();
        });
        Schema::table('initiative_audience', function (Blueprint $table) {
            $table->removeColumn('id');
            $table->integer('audience_id')->unsigned();
            $table->foreign('audience_id')->references('id')->on('audience')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('initiative_audience_other', function (Blueprint $table) {
            $table->integer('audience_id')->unsigned();
            $table->string('name');

            $table->foreign('audience_id')
                ->references('id')->on('initiative_audience')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('initiative_audience', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audience_id')->unsigned()->index();
            $table->foreign('audience_id')->references('id')->on('audience')->onDelete('cascade');
        });
        Schema::drop('audience');
    }
}
