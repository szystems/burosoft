<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rtributa extends Model
{
    use HasFactory;    // Propiedades fillable
    protected $fillable = [
        'fecha_hora_notificacion',
        'numero_resolucion',
        'tipo_resolucion',
        'tipo_resolucion_otro',
        'fecha_resolucion',
        'plazo_cat',
        'plazo_cat_otro',
        'archivo',
        'tipo_archivo',
        'usuario_id',
        'audiencia_id',
        'observaciones',
        'numero_folios',
    ];

    // Conversión de tipos
    protected $casts = [
        'fecha_hora_notificacion' => 'datetime',
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
