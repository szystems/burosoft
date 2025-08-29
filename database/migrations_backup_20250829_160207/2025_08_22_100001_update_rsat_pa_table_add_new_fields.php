<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRsatPaTableAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Agregar los nuevos campos
        Schema::table('rsat_pa', function (Blueprint $table) {
            $table->string('tipo_resolucion_otro')->nullable()->after('tipo_resolucion');
            $table->enum('plazo_revocatoria', ['5 D.H.', '10 D.H.', '30 D.H.', 'otro'])->nullable()->after('tipo_resolucion_otro');
            $table->string('plazo_revocatoria_otro')->nullable()->after('plazo_revocatoria');
        });

        // Modificar el enum para incluir 'otro'
        Schema::table('rsat_pa', function (Blueprint $table) {
            $table->dropColumn('tipo_resolucion');
        });
        
        Schema::table('rsat_pa', function (Blueprint $table) {
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro'])->nullable()->after('numero_folios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rsat_pa', function (Blueprint $table) {
            $table->dropColumn(['tipo_resolucion_otro', 'plazo_revocatoria', 'plazo_revocatoria_otro']);
        });
        
        Schema::table('rsat_pa', function (Blueprint $table) {
            $table->dropColumn('tipo_resolucion');
        });
        
        Schema::table('rsat_pa', function (Blueprint $table) {
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal'])->nullable()->after('numero_folios');
        });
    }
}
