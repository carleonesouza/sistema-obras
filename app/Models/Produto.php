<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];


    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_produto');
    }
}
