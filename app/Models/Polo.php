<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Polo extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'endereco', 'localizacao', 'status'];

    public function scopeExibicao($query){
        return $query->where('status', 'Ativo')
                     ->where('id', Auth::user()->cd_polo);
    }
}
