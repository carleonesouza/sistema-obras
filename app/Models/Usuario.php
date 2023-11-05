<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $instituicao_setor;
    public $tipo_usuario;
    protected $senha;
}
