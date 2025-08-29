<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoPa extends Model
{
    use HasFactory;

    protected $table = 'ros_pa';

    protected $fillable = [
        'fecha',
        'fecha_notificacion',
        'fecha_resolucion',
        'numero_resolucion',
        'tipo_resolucion',
        'archivo',
        'tipo_archivo',
        'usuario_id',
        'audiencia_pa_id',
        'observaciones',
        'numero_folios',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_notificacion' => 'datetime',
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
