<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    protected $fillable = ['id_usuario', 'id_sala'];

    public function scopeCountMaquinas($query, $id_sala)
    {
        return $query->where('id_sala', $id_sala)->count();
    }

    public function scopeVerificaAgenda($query, $id_aluno, $id_sala)
    {
        return $query->where([
            ['id_usuario', $id_aluno],
            ['id_sala', $id_sala]
        ]);
    }

    public function scopeDeleteCadastro($query, $id)
    {
        return $query->find($id);
    }

    public function scopeMinhaLista($query, $id_aluno)
    {
        return $query->join('salas', 'salas.id', '=', 'cadastros.id_sala')
                     ->where('cadastros.id_usuario', $id_aluno)
                     ->select('salas.id', 'salas.bloco', 'salas.hora', 'salas.data', 'cadastros.id AS id_cadastro', 'salas.nsala');
    }

    public function setDateFormatedAttribute($value)
    {
        $this->attributes['date_formated'] = date('d/m/Y', strtotime($value));
    }

    public function setHourFormatedAttribute($value)
    {
        $this->attributes['hour_formated'] = date('H:i', strtotime($value));
    }

    use HasFactory;
}
