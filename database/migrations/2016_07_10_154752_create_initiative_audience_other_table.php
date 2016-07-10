<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitiativeAudienceOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiative_audience_other', function (Blueprint $table) {
            $table->integer('audience_id')->unsigned();
            $table->string('name');

            $table->foreign('audience_id')
                ->references('id')->on('initiative_audience')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('initiative_audience_other');
    }
}
