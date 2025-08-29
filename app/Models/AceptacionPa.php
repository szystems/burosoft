<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AceptacionPa extends Model
{
    use HasFactory;

    protected $table = 'aceptacions_pa';

    protected $fillable = [
        'fecha_hora_presentacion',
        'numero_documento',
        'usuario_id',
        'audiencia_pa_id',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'oficina_presentacion',
        'numero_folios'
    ];

    protected $casts = [
        'fecha_hora_presentacion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function audienciaPa()
    {
        return $this->belongsTo(AudienciaPa::class, 'audiencia_pa_id');
    }
}
