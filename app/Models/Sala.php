<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sala extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['bloco', 'hora', 'data', 'qtd_maquinas', 'nsala', 'polo', 'qtd_maquinas_original', 'status'];

    public function scopeJoinPolos($query){
        return $query->join('polos', 'salas.polo', '=', 'polos.id')
                     ->select('salas.id', 'polos.descricao', 'salas.data', 'salas.hora', 'salas.qtd_maquinas', 'salas.bloco');
    }

    public function scopeExibicao($query)
    {
        return $query->joinPolos()
                     ->where('data', '>=', date('Y-m-d'));
    }

    public function scopeStatusAtivo($query)
    {
        return $query->where('salas.status', 'Ativo');
    }

    public function scopeVerificaPolo($query){
        return $query->where('polo', Auth::user()->cd_polo);
    }

    public function scopeGroupDatas($query){
        return $query->select('data')
                     ->where('data', '>', date('Y-m-d'))
                     ->groupBy('data');
    }

    public function scopeData($query, $data)
    {
        return $query->where('data', $data);
    }

    public function scopeSalasExport($query, $data)
    {
        return $query->select('name', 'bloco', 'hora')
                     ->join('cadastros', 'cadastros.id_sala', 'salas.id')
                     ->join('users', 'users.id', 'cadastros.id_usuario')
                     ->where('data', $data)
                     ->orderBy('name', 'asc')
                     ->orderBy('hora', 'asc');
    }

    public function scopeHora($query, $hora)
    {
        return $query->where('hora', date('H:i:s', strtotime($hora)));
    }

    public function scopePolo($query, $polo)
    {
        return $query->where('polo', $polo);
    }

    public function scopeOrderByData($query){
        return $query->orderBy('data', 'asc');
    }

    public function scopeOrderByHora($query){
        return $query->orderBy('hora', 'asc');
    }

    public function scopeOrderByBloco($query){
        return $query->orderBy('bloco', 'asc');
    }

    public function setDateFormatedAttribute($value)
    {
        $this->attributes['date_formated'] = date('d/m/Y', strtotime($value));
    }

    public function setHourFormatedAttribute($value)
    {
        $this->attributes['hour_formated'] = date('H:i', strtotime($value));
    }

    public function cadastros()
    {
        return $this->belongsToMany(Cadastro::class, 'id_sala');
    }
}
