<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatNotificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'fecha',
        'hora',
        'tipo_notificacion',
        'recibio',
        'domicilio_notificacion',
        'domicilio_notificacion_es',
        'domicilio_notificacion_otro',
        'persona_idonea',
        'folios_notificados',
        'acto_notificado',
        'plazo_atencion',
        'vencimiento_plazo',
        'archivo',
        'tipo',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pat()
    {
        return $this->belongsTo(Cuenta::class, 'pat_id');
    }
}
