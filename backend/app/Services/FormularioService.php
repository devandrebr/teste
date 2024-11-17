<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\FormularioServiceInterface;
use App\Repositories\FormularioRepository;
use App\Repositories\FormularioRespostaRepository;
use Exception;

class FormularioService implements FormularioServiceInterface
{
    protected $formRepository;
    protected $formRespostaRepository;

    public function __construct(FormularioRepository $formRepository, FormularioRespostaRepository $formRespostaRepository)
    {
        $this->formRepository = $formRepository;
        $this->formRespostaRepository = $formRespostaRepository;
    }

    public function salvarRespostas(Request $request, $formId)
    {
        $formulario = $this->formRepository->getById($formId);

        if (!$formulario) {
            throw new Exception('Formulário não encontrado, código incorreto.', 404);
        }

        $rules = [];
        foreach ($formulario['fields'] as $field) {
            $rule = [];
            if ($field['required']) {
                $rule[] = 'required';
            }
            switch ($field['type']) {
                case 'text':
                    $rule[] = 'string';
                    break;
                case 'number':
                    $rule[] = 'numeric';
                    break;
                case 'select':
                    $rule[] = 'in:' . implode(',', $field['choices']);
                    break;
            }
            $rules[$field['id']] = $rule;
        }

        dd($rules);

        die;


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 400);
        }

        // @todo salvar formulario
        $dados = $request->all();
        $dados['form_id'] = $formId; 

        // @todo para salvar o id do formulário
        

        $resposta = $this->formRespostaRepository->salvar($dados);

        return $resposta;
    }

    public function listaRespostas($formId)
    {
        $formulario = $this->formRepository->getById($formId);

        if (!$formulario) {
            throw new Exception('Formulário não encontrado', 404);
        }

        $id = $formulario['id'];

        $respostas = $this->formRespostaRepository->getByForm($id);

        return $respostas;
    }
}