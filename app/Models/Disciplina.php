<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    public function scopeJoinUserDisciplinas($query, $id_aluno){
        return $query->join('user_disciplinas', 'disciplinas.id', 'user_disciplinas.id_disciplina')
                     ->where('user_disciplinas.id_user', $id_aluno);
    }
}
