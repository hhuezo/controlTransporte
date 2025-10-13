<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoControl extends Model
{
    use HasFactory;

    protected $table = 'puntos_control';

    protected $fillable = [
        'viaje_id',
        'motorista_id',
        'tipo',
        'latitud',
        'longitud',
        'hora_reporte',
        'observacion',
    ];

    protected $casts = [
        'hora_reporte' => 'datetime',
        'latitud' => 'decimal:7',
        'longitud' => 'decimal:7',
    ];

    /**
     * Relación con el modelo Viaje.
     */
    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }

    /**
     * Relación con el modelo User (Motorista).
     */
    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id');
    }
}
