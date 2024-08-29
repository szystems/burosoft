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
        'tipo_requerimiento',
        'lugar_atender',
        'plazo_atencion',
        'tipo_revision',
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
