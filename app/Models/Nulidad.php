<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nulidad extends Model
{
    use HasFactory;

    protected $table = 'nulidades';    protected $fillable = [
        'audiencia_id',
        'usuario_id',
        'fecha_hora_notificacion',
        'fecha_resolucion',
        'numero_resolucion',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'tipo_nulidad',
        'numero_folios',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora_notificacion' => 'datetime',
            'fecha_resolucion' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relación con Audiencia
    public function audiencia()
    {
        return $this->belongsTo(Audiencia::class);
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
