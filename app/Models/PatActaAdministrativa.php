<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatActaAdministrativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'fecha',
        'quienes_intervinieron',
        'tipo_acta',
        'tipo_acta_otro',
        'observaciones',
        'archivo',
        'tipo',
        'usuario_id',
    ];

    protected $casts = [
        'fecha' => 'date',
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
