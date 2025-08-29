<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJuzgadoAndMedidasToEcsPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecs_pa', function (Blueprint $table) {
            $table->string('juzgado_que_conoce')->nullable()->after('fecha_resolucion');
            $table->json('medidas_decretadas')->nullable()->after('juzgado_que_conoce');
            $table->string('medidas_decretadas_otro')->nullable()->after('medidas_decretadas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecs_pa', function (Blueprint $table) {
            $table->dropColumn(['juzgado_que_conoce', 'medidas_decretadas', 'medidas_decretadas_otro']);
        });
    }
}
