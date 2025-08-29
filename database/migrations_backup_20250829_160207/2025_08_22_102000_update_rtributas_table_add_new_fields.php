<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRtributasTableAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cambiar fecha a datetime y renombrar
        Schema::table('rtributas', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
        
        Schema::table('rtributas', function (Blueprint $table) {
            $table->datetime('fecha_hora_notificacion')->after('id');
            $table->date('fecha_resolucion')->nullable()->after('numero_resolucion');
            $table->string('tipo_resolucion_otro')->nullable()->after('tipo_resolucion');
            $table->enum('plazo_cat', ['30 D.H.', '3 Meses', 'otro'])->nullable()->after('tipo_resolucion_otro');
            $table->string('plazo_cat_otro')->nullable()->after('plazo_cat');
        });

        // Modificar el enum para incluir 'otro'
        Schema::table('rtributas', function (Blueprint $table) {
            $table->dropColumn('tipo_resolucion');
        });
        
        Schema::table('rtributas', function (Blueprint $table) {
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro'])->after('fecha_resolucion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rtributas', function (Blueprint $table) {
            $table->dropColumn(['fecha_hora_notificacion', 'fecha_resolucion', 'tipo_resolucion_otro', 'plazo_cat', 'plazo_cat_otro']);
        });
        
        Schema::table('rtributas', function (Blueprint $table) {
            $table->dropColumn('tipo_resolucion');
        });
        
        Schema::table('rtributas', function (Blueprint $table) {
            $table->date('fecha')->after('id');
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal'])->after('numero_resolucion');
        });
    }
}
