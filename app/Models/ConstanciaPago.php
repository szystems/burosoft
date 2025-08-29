<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstanciaPago extends Model
{
    use HasFactory;

    protected $table = 'constancia_pagos';

    protected $fillable = [
        'pat_id',
        'usuario_id', 
        'fecha_pago',
        'identificacion',
        'descripcion',
        'archivo',
        'tipo_archivo'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
    ];

    public function pat()
    {
        return $this->belongsTo(Pat::class, 'pat_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
