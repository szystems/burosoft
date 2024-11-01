<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatRequerimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'no',
        'fecha',
        'fecha_maxima',
        'tipo_requerimiento',
        'tipo_requerimiento_otro',
        'lugar_atender',
        'domicilio',
        'plazo_atencion',
        'tipo_revision',
        'tipo_revision_otro',
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
