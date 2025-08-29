<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatRct extends Model
{
    use HasFactory;

    protected $table = 'pat_rcts';
    protected $fillable = [
        'pat_id',
        'fecha_citacion',
        'medio_citacion',
        'medio_citacion_otro',
        'fecha_atencion',
        'participantes_reunion',
        'lugar_celebracion',
        'descripcion_resultado',
        'suscribe_acta',
        'archivo_acta',
        'tipo_archivo_acta',
        'archivo_recibo_pago',
        'tipo_archivo_recibo',
        'usuario_id'
    ];

    public function pat()
    {
        return $this->belongsTo(Pat::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
