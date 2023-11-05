<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'instituicao_setor',
        'tipo_usuario_id',
        'senha'
    ];

}
