<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rr extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_hora_presentacion',
        'numero_documento',
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
