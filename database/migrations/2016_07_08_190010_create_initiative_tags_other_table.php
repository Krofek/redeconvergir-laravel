<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitiativeTagsOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiative_tags_other', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->string('name');

            $table->foreign('tag_id')
                ->references('id')->on('initiative_tags')
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
        Schema::drop('initiative_tags_other');
    }
}
