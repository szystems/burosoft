<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'usuario_id',
        'empresa_id',
        'cuenta_id',
        'rubro_id',
        'monto_q',
        'monto_d',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }

    public function rubro()
    {
        return $this->belongsTo(Rubro::class, 'rubro_id');
    }
}
