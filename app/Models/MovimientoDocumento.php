<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'movimiento_id',
        'archivo',
        'nombre',
        'descripcion',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
