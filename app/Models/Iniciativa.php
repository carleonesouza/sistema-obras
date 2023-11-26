<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'usuario_que_alterou',
        'setor',
        'usuario',
        'usuario_alteracao'
    ];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class, 'setor');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status');
    }

}
