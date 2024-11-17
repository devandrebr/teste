<?php

namespace App\Repositories;

use App\Models\FormularioResposta;
use App\Models\FormularioRespostaLabel;
use App\Interfaces\FormularioRespostaLabelRepositoryInterface;

class FormularioRespostaLabelRepository implements FormularioRespostaLabelRepositoryInterface
{
    public function salvar(array $data)
    {
        return FormularioRespostaLabel::insert($data); 
    }
}