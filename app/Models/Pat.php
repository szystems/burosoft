<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pat extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta_id',
        'usuario_id',
        'no_expediente',
        'no_programa',
        'gerencia',
        'tipo_contribuyente',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function Cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }
}
