<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $fillable = ['bloco', 'hora', 'data', 'qtd_maquinas', 'nsala', 'polo'];

    public function scopeJoinPolos($query){
        return $query->join('polos', 'salas.id', '=', 'polos.id')
                     ->select('salas.id', 'polos.descricao', 'salas.data', 'salas.hora', 'salas.qtd_maquinas');
    }

    public function scopeExibicao($query)
    {
        return $query->joinPolos()
                     ->where('data', '>=', date('Y-m-d'));
    }

    public function scopeData($query, $data)
    {
        return $query->where('data', $data);
    }

    public function scopeHora($query, $hora)
    {
        return $query->where('hora', date('H:i:s', strtotime($hora)));
    }

    public function scopePolo($query, $polo)
    {
        return $query->where('polo', $polo);
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
