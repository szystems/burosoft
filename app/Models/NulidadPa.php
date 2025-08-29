<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NulidadPa extends Model
{
    use HasFactory;

    protected $table = 'nulidades_pa';


    protected $fillable = [
        'fecha_hora_notificacion',
        'fecha_resolucion',
        'numero_resolucion',
        'tipo_nulidad',
        'usuario_id',
        'audiencia_pa_id',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'numero_folios',
    ];

    protected $casts = [
        'fecha_hora_notificacion' => 'datetime',
        'fecha_resolucion' => 'date',
    ];

    // Relación con AudienciaPa
    public function audienciaPa()
    {
        return $this->belongsTo(AudienciaPa::class, 'audiencia_pa_id');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
