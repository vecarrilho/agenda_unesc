<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    public function scopeExibicao($query){
        return $query->where('data', '>=', date('Y-m-d'));
    }

    public function scopeData($query, $data){
        return $query->where('data', $data);
    }

    public function scopeHora($query, $hora){
        return $query->where('hora', date('H:i:s', strtotime($hora)));
    }

    use HasFactory;
}
