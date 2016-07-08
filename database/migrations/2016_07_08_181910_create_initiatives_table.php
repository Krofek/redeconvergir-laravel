<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitiativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->string('promoter');
            $table->longText('description');

            $table->string('url');
            $table->string('logo_url');
            $table->string('doc_url');
            $table->string('video_url');

            $table->integer('visitors');
            $table->integer('group_size');
            $table->integer('area_size');

            $table->timestamp('start_at');

            // foreign keys
            $table->integer('category_id')->nullable(false)->unsigned();
            $table->foreign('category_id')->references('id')->on('initiative_categories');

            $table->integer('location_id')->nullable(false)->unsigned();
            $table->foreign('location_id')->references('id')->on('locations');

            $table->integer('contact_id')->nullable(false)->unsigned();
            $table->foreign('contact_id')->references('id')->on('contacts');
            //
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
        Schema::drop('initiatives');
    }
}
