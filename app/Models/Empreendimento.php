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
        'setor',
        'obras',
        'usuario_que_alterou',
        'user',
        'status'
    ];
 
    public function obras(): MorphMany {
        return $this->morphMany(Obra::class, 'obraable');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user');
    }
    
    public function setor() {
        return $this->belongsTo(Setor::class, 'setor');
    }

}
