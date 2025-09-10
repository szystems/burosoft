<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'usuario_id',
        'numero_audiencia',
        'tipo_audiencia',
        'tipo_audiencia_otro',
        'fecha',
        'impuestos',
        'archivo',
        'tipo_archivo',
        'fecha_notificacion',
        'plazo_evacuar',
        'plazo_evacuar_otro'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'fecha_notificacion' => 'datetime',
        'impuestos' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pat()
    {
        return $this->belongsTo(Pat::class, 'pat_id');
    }
}
