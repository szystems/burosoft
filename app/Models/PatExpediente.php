<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatExpediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'fecha',
        'nombre',
        'descripcion',
        'archivo',
        'tipo',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pat()
    {
        return $this->belongsTo(Cuenta::class, 'pat_id');
    }
}
