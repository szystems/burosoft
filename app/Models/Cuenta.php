<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    protected $table = 'cuentas';

    protected $fillable = [
        'nit',
        'dpi',
        'razon_social',
        'telefono',
        'correo',
        'direccion',
        'otra_forma_contacto',
        'datos_intermediario_nombre',
        'datos_intermediario_telefono',
        'datos_intermediario_correo',
        'datos_propietario_nombre',
        'datos_propietario_telefono',
        'datos_propietario_correo'
    ];
}
