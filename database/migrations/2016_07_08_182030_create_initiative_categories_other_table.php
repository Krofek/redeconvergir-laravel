<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitiativeCategoriesOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiative_categories_other', function (Blueprint $table) {
            $table->integer('initiative_id')->unsigned();
            $table->string('name');

            $table->foreign('initiative_id')
                ->references('id')->on('initiatives')
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
        Schema::drop('initiative_categories_other');
    }
}
