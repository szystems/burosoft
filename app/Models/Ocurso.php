<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocurso extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_hora_presentacion',
        'numero_documento',
        'oficina_agencia_ea',
        'usuario_id',
        'audiencia_id',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'numero_folios'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function audiencia()
    {
        return $this->belongsTo(Audiencia::class, 'audiencia_id');
    }
}
