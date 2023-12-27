<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Setor extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    public function iniciativas(): HasOne
    {
        return $this->hasOne(Iniciativa::class);
    }

}
