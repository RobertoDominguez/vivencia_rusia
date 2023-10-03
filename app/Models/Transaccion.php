<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;
    
    protected $table='Transaccion';
    protected $fillable=[
        'monto',
        'id_tipo',
        'fecha',
        'es_entrada',
        'es_servicio',
        'duracion'
    ];

    
}
