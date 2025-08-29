<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtributaPa extends Model
{
    use HasFactory;

    protected $table = 'rtributas_pa';

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
        'audiencia_pa_id',
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
