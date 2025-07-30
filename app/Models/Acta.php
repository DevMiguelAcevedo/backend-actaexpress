<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Acta extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'actas';

    protected $fillable = [
        'titulo',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'orden_dia',
        'desarrollo',
        'acuerdos',
        'responsable',
        'asistentes',
        'firmas',
        'objetivos',
        'compromisos',
        'minuta',
        'conclusiones',
        'notas',
        'estado'
    ];

    protected $casts = [
        'asistentes' => 'array',
        'firmas'     => 'array',
    ];
}
