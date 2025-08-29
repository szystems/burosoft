<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOficinaPresentacionToAdpmrsPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adpmrs_pa', function (Blueprint $table) {
            $table->string('oficina_presentacion')->nullable()->after('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adpmrs_pa', function (Blueprint $table) {
            $table->dropColumn('oficina_presentacion');
        });
    }
}
