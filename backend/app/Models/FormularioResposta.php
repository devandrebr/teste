<?php

namespace App\Models;

use App\Repositories\FormularioRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioResposta extends Model
{
    use HasFactory;

    protected $table = 'formulario_resposta';

    protected $fillable = [
        'id',
        'id_formulario',
        'user_agent',
        'endereco_ip',
        'created_at',
        'updated_at'
    ];

    public function labels()
    {
        return $this->hasMany(FormularioRespostaLabel::class, 'id_resposta');
    }

    public function getRespostasLabelsByForm(string $formId)
    {
        return FormularioResposta::with('labels')
            ->where('id_formulario', $formId) 
            ->get()->toArray();
    }
}