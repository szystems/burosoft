<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcPa extends Model
{
    use HasFactory;

    protected $table = 'ecs_pa';

    protected $fillable = [
        'numero_resolucion',
        'usuario_id',
        'audiencia_pa_id',
        'observaciones',
        'numero_folios',
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
