<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ec extends Model
{
    use HasFactory;    protected $fillable = [
        'audiencia_id',
        'numero_resolucion',
        'observaciones',
        'usuario_id',
        'numero_folios'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con la audiencia
    public function audiencia()
    {
        return $this->belongsTo(Audiencia::class);
    }

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
