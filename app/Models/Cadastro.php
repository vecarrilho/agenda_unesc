<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cadastro extends Model
{
    use HasFactory;

    protected $fillable = ['id_usuario', 'id_sala'];

    public function scopeCountMaquinas($query, $id_sala)
    {
        return $query->where('id_sala', $id_sala)->count();
    }

    public function scopeJoinSalas($query){
        return $query->join('salas', 'cadastros.id_sala', 'salas.id');
    }

    public function scopeJoinUsers($query){
        return $query->join('users', 'cadastros.id_usuario', 'users.id');
    }

    public function scopeJoinPolos($query){
        return $query->join('polos', 'salas.polo', 'polos.id');
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
                     ->join('polos', 'polos.id', '=', 'salas.polo')
                     ->where('cadastros.id_usuario', $id_aluno)
                     ->where('salas.data', '>=', date('Y-m-d'))
                     ->select('salas.id', 'salas.bloco', 'salas.hora', 'salas.data', 'cadastros.id AS id_cadastro', 'salas.nsala', 'salas.polo', 'polos.descricao');
    }

    public function scopeCountCadastros($query){
        return $query->join('salas', 'salas.id', '=', 'cadastros.id_sala')
                     ->where('cadastros.id_usuario', Auth::user()->id)
                     ->where('salas.data', '>', date('Y-m-d'));
    }

    public function setDateFormatedAttribute($value)
    {
        $this->attributes['date_formated'] = date('d/m/Y', strtotime($value));
    }

    public function setHourFormatedAttribute($value)
    {
        $this->attributes['hour_formated'] = date('H:i', strtotime($value));
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($model)  {
             $sala = Sala::find($model->id_sala);
             $sala->qtd_maquinas--;
             $sala->save();
        });

        static::deleted(function ($model)  {
            $sala = Sala::find($model->id_sala);
            $sala->qtd_maquinas++;
            $sala->save();
        });
    }


}
