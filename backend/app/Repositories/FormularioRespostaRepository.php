<?php

namespace App\Repositories;

use App\Models\Formulario;
use App\Models\FormularioResposta;
use App\Interfaces\FormularioRespostaRepositoryInterface;

class FormularioRespostaRepository implements FormularioRespostaRepositoryInterface
{
    public function salvar(array $data)
    {
        return FormularioResposta::create($data); 
    }

    public function getByForm(string $formId)
    {
        return FormularioResposta::where('id_formulario', $formId)->get(); 
    }

    public function getRespostas(int $respostaId)
    {
        $resposta = FormularioResposta::find($respostaId);
        return $resposta->labels; 
    }

    public function getRespostasByForm(string $formId, int $offset, int $limit)
    {
        $form = new FormularioResposta();
        $resposta = $form->getRespostasLabelsByForm($formId, $offset, $limit);

        return $resposta; 
    }
}