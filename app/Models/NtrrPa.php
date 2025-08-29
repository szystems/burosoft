<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NtrrPa extends Model
{
    use HasFactory;

    protected $table = 'ntrrs_pa';

    protected $fillable = [
        'fecha_hora_notificacion',
        'numero_resolucion',
        'fecha_resolucion',
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
