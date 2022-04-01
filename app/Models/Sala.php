<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    public function scopeExibicao($query)
    {
        return $query->where('data', '>=', date('Y-m-d'));
    }

    public function scopeData($query, $data)
    {
        return $query->where('data', $data);
    }

    public function scopeHora($query, $hora)
    {
        return $query->where('hora', date('H:i:s', strtotime($hora)));
    }

    public function scopeBloco($query, $hora)
    {
        return $query->where('bloco');
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
