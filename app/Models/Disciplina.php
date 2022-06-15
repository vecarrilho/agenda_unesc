<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;
    
    protected $fillable = ['ano','trimestre', 'nm_disciplina', 'nm_reduzido', 'cd_disciplina'];

    public function scopeJoinUserDisciplinas($query, $cd_aluno){
        return $query->join('user_disciplinas', 'user_disciplinas.cd_disciplina', 'disciplinas.cd_disciplina')
                     ->where('user_disciplinas.cd_user', $cd_aluno)
                     ->select('disciplinas.cd_disciplina', 'disciplinas.nm_reduzido');
    }
}
