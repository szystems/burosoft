<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatNotificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'tipo_notificacion',
        'recibio',
        'domicilio_notificacion',
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
