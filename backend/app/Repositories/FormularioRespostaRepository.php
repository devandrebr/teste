<?php

namespace App\Repositories;

use App\Models\Formulario;
use App\Models\FormularioResposta;
use App\Interfaces\FormularioRespostaRepositoryInterface;

class FormularioRespostaRepository implements FormularioRespostaRepositoryInterface
{
    public function salvar(array $data)
    {
        // @todo: lógica para salvar os dados no banco de dados usando o modelo Preenchimento
        return FormularioResposta::create($data); 
    }

    public function getByForm($formId)
    {
        // @todo: lógica para buscar as respostas do formulário no banco de dados
        return FormularioResposta::where('form_id', $formId)->get(); 
    }
}