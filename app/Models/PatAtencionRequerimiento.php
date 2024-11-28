<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatAtencionRequerimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'no',
        'fecha',
        'forma_atencion',
        'forma_atencion_otro',
        'acta_administrativa',
        'quien_atendio',
        'observaciones',
        'archivo',
        'tipo',
        'usuario_id',
        'entregado_en',
        'entregado_en_otro',
        'oficio_respuesta',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function pat()
    {
        return $this->belongsTo(Cuenta::class, 'pat_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
