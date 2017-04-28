<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInitiativeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initiatives', function (Blueprint $table) {
            $table->dropColumn('promoter');
            $table->string('short_description', 140);
            $table->string('keywords');
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
            $table->string('promoter');
            $table->dropColumn('short_description');
            $table->dropColumn('keywords');
        });
    }
}
