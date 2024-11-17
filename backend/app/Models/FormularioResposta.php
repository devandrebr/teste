<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioResposta extends Model
{
    use HasFactory;

    protected $table = 'formulario_resposta';

    protected $fillable = [
        'form_id',
        'resposta',
        'created_at',
        'updated_at'
    ];
}