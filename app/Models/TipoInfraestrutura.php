<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInfraestrutura extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'setor',
    ];


    public function setor() {
        return $this->belongsTo(Setor::class, 'setor');
    }
}
