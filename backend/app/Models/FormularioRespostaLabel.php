<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioRespostaLabel extends Model
{
    use HasFactory;

    protected $table = 'formulario_resposta_label';

    protected $fillable = [
        'id',
        'id_resposta',
        'id_label',
        'resposta',
        'created_at',
        'updated_at'
    ];
}