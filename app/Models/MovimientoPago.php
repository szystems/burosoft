<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'movimiento_id',
        'descripcion',
        'forma_pago',
        'imagen',
        'usuario_id',
        'monto_q',
        'monto_d'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
