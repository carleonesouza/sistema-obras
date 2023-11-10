<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iniciativa extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome',
        'responsavel',
        'ele_principal_afetado',
        'expectativa',
        'status',
        'instrumento', 
        'setor',
        'usuario',      
        'usuario_alteracao'
    ];

}
