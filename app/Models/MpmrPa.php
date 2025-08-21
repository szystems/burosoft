<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpmrPa extends Model
{
    use HasFactory;

    protected $table = 'mpmrs_pa';

    protected $fillable = [
        'fecha_hora',
        'numero_resolucion',
        'usuario_id',
        'audiencia_pa_id',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'numero_folios',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
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
