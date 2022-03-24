<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    public function scopeExibicao($query){
        return $query->where('data', '>=', date('Y-m-d'));
    }
    use HasFactory;
}
