<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpmr extends Model
{
    use HasFactory;

    // Propiedades fillable
    protected $fillable = [
        'fecha_hora',
        'fecha_resolucion',
        'numero_resolucion',
        'archivo',
        'tipo_archivo',
        'usuario_id',
        'audiencia_id',
        'observaciones',
        'numero_folios'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
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
