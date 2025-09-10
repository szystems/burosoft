<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudienciaPa extends Model
{
    use HasFactory;

    protected $table = 'audiencias_pa';

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

    // Relación con PAT
    public function pat()
    {
        return $this->belongsTo(Pat::class);
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relaciones con los módulos PA
    public function evsPa()
    {
        return $this->hasMany(EvPa::class, 'audiencia_pa_id');
    }

    public function ppsPa()
    {
        return $this->hasMany(PpPa::class, 'audiencia_pa_id');
    }

    public function dpmrsPa()
    {
        return $this->hasMany(DpmrPa::class, 'audiencia_pa_id');
    }

    public function adpmrsPa()
    {
        return $this->hasMany(AdpmrPa::class, 'audiencia_pa_id');
    }

    public function rsatPa()
    {
        return $this->hasMany(RsatPa::class, 'audiencia_pa_id');
    }

    public function rtributaPa()
    {
        return $this->hasMany(RtributaPa::class, 'audiencia_pa_id');
    }

    public function nulidadesPa()
    {
        return $this->hasMany(NulidadPa::class, 'audiencia_pa_id');
    }

    public function ecsPa()
    {
        return $this->hasMany(EcPa::class, 'audiencia_pa_id');
    }

    public function rrsPa()
    {
        return $this->hasMany(RrPa::class, 'audiencia_pa_id');
    }

    public function ntrrsPa()
    {
        return $this->hasMany(NtrrPa::class, 'audiencia_pa_id');
    }

    public function ocursosPa()
    {
        return $this->hasMany(OcursoPa::class, 'audiencia_pa_id');
    }

    public function rosPa()
    {
        return $this->hasMany(RoPa::class, 'audiencia_pa_id');
    }

    public function mpmrsPa()
    {
        return $this->hasMany(MpmrPa::class, 'audiencia_pa_id');
    }

    public function ampmrsPa()
    {
        return $this->hasMany(AmpmrPa::class, 'audiencia_pa_id');
    }
}
