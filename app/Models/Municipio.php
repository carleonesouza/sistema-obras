<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'uf',
    ];

    public function UF() {
        return $this->belongsTo(UF::class, 'uf');
    }

    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_municipios');
    }
}
