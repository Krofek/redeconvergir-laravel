<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInitiativeCategoriesRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initiatives', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        Schema::drop('initiative_categories');
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        # many to many
        Schema::create('initiative_category', function (Blueprint $table) {
            $table->integer('initiative_id')->unsigned()->index();
            $table->foreign('initiative_id')->references('id')->on('initiatives')->onDelete('cascade');

            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::drop('initiative_category');
        Schema::drop('categories');
        Schema::create('initiative_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::table('initiatives', function (Blueprint $table) {
            $table->integer('category_id')->nullable(false)->unsigned();
            $table->foreign('category_id')->references('id')->on('initiative_categories');
        });
    }
}
