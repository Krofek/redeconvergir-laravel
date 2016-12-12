<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('street');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropColumn('country');
            $table->string('facebook');
            $table->string('website');
            $table->integer('initiative_id')->unsigned()->nullable();
            $table->foreign('initiative_id')->references('id')->on('initiatives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('street');
            $table->string('city');
            $table->integer('postal_code');
            $table->string('country');
            $table->dropColumn('facebook');
            $table->dropColumn('website');
            $table->dropForeign(['initiative_id']);
            $table->dropColumn('initiative_id');
        });
    }
}
