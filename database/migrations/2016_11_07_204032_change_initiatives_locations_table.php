<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInitiativesLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initiatives', function (Blueprint $table) {
            $table->dropColumn('doc_url');
            $table->dropColumn('accepts_visits');
            $table->string('cover_photo_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('initiatives', function (Blueprint $table) {
            $table->string('doc_url');
            $table->tinyInteger('accepts_visits');
            $table->dropColumn('cover_photo_url');
        });
    }
}
