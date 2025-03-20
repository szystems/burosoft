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
        'fecha',
        'impuestos',
        'archivo',
        'tipo_archivo'
    ];

    protected $dates = ['fecha'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pat()
    {
        return $this->belongsTo(Pat::class, 'pat_id');
    }
}
