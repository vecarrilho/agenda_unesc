<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDisciplina extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['cd_user', 'cd_disciplina', 'ano', 'trimestre'];
}
