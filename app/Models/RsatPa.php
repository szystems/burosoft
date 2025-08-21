<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsatPa extends Model
{
    use HasFactory;

    protected $table = 'rsat_pa';

    protected $fillable = [
        'numero_resolucion',
        'fecha',
        'usuario_id',
        'audiencia_pa_id',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'numero_folios',
        'tipo_resolucion',
    ];

    protected $casts = [
        'fecha' => 'date',
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
