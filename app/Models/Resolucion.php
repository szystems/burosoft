<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resolucion extends Model
{
    use HasFactory;

    // Propiedades fillable
    protected $fillable = [
        'fecha',
        'fecha_notificacion',
        'fecha_resolucion',
        'numero_resolucion',
        'tipo_resolucion',
        'tipo_resolucion_otro',
        'plazo_revocatoria',
        'plazo_revocatoria_otro',
        'archivo',
        'tipo_archivo',
        'usuario_id',
        'audiencia_id',
        'observaciones',
        'numero_folios'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_notificacion' => 'datetime',
        'fecha_resolucion' => 'date',
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Audiencia
    public function audiencia()
    {
        return $this->belongsTo(Audiencia::class);
    }
}
