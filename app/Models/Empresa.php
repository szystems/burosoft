<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'celular',
        'direccion',
        'descripcion',
        'fotografia',
        'estado',
    ];

    public function config()
    {
        return $this->hasOne(Config::class);
    }
}
