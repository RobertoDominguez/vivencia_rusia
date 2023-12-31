<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='Tipo';

    protected $fillable=[
        'nombre',
        'id_user'
    ];

}
