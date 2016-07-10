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
            $table->integer('category_id')->nullable(false)->unsigned();

            $table->longText('description');
            $table->integer('status');

            $table->integer('contact_id')->nullable(false)->unsigned();
            $table->string('url');
            $table->string('logo_url');
            $table->string('doc_url');
            $table->string('video_url');

            $table->timestamp('start_at');

            $table->integer('audience_size');
            $table->integer('group_size');
            $table->integer('area_size');

            $table->tinyInteger('accepts_visits');
            $table->tinyInteger('location_type');

            $table->integer('location_id')->nullable(false)->unsigned();

            $table->string('promoter');

            // foreign keys

            $table->foreign('category_id')->references('id')->on('initiative_categories');

            $table->foreign('location_id')->references('id')->on('locations');

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
