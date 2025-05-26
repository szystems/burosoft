<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpmr extends Model
{
    use HasFactory;

    // Propiedades fillable
    protected $fillable = [
        'fecha',
        'numero_resolucion',
        'archivo',
        'tipo_archivo',
        'usuario_id',
        'audiencia_id',
        'observaciones'
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
