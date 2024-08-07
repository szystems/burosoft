<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatNombramiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'pat_id',
        'no',
        'nombrado_1',
        'nombrado_2',
        'nombrado_3',
        'nombrado_4',
        'nombrado_5',
        'periodo',
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
