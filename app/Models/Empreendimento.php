<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Empreendimento extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'responsavel',
        'respondente',
        'setor',
        'obras',
        'status'
    ];
 
    public function obras(): MorphMany {
        return $this->morphMany(Obra::class, 'obraable');
    }

}
