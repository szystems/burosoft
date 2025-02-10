<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatRaf extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'no',
        'fecha',
        'tipo_providencia',
        'tipo_providencia_otro',
        'admite',
        'admite_otro',
        'observaciones',
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
