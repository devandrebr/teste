<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\FormularioServiceInterface;
use App\Repositories\FormularioRepository;
use App\Repositories\FormularioRespostaRepository;
use App\Repositories\FormularioRespostaLabelRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class FormularioService implements FormularioServiceInterface
{
    protected $formRepository;
    protected $formRespostaRepository;
    protected $formRespostaLabelRepository;

    public function __construct(FormularioRepository $formRepository, FormularioRespostaRepository $formRespostaRepository, FormularioRespostaLabelRepository $formRespostaLabelRepository)
    {
        $this->formRepository = $formRepository;
        $this->formRespostaRepository = $formRespostaRepository;
        $this->formRespostaLabelRepository = $formRespostaLabelRepository;
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

        $keyIdRules = array_keys($rules);

        $dados = $request->all();

        // 1º array $respostas no padrão para usar na validação
        // 2º array $dadosLabel utilizado para salvar os dados no banco de dados, após conseguir o id da resposta
        $respostas = $dadosLabel = [];
        $i = 0;
        foreach ($dados['fields'] as $campo) {
            $id = $campo['id'];
            $texto = $campo['texto'];

            // validação para checkar o id do form e não o id via payload do frontend
            // garantindo a consistência dos dados
            if (in_array($id, $keyIdRules)) {
                $respostas[$campo['id']] = $campo['texto'];
                $dadosLabel[$i]['id_label'] = $id;
                $dadosLabel[$i]['resposta'] = $texto;

                $i++;
            }
        }

        $validator = Validator::make($respostas, $rules);
        
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 400);
        }

        try {
            $dadosResposta['id_formulario'] = $formId; 
            $dadosResposta['user_agent'] = $dados['user_agent'];
            $dadosResposta['endereco_ip'] = $dados['endereco_ip'];

            DB::beginTransaction();

            $resposta = $this->formRespostaRepository->salvar($dadosResposta);

            if (!is_int($resposta->id) || (int)$resposta->id <= 0)
            throw new Exception($validator->errors(), 400);

            $idResposta = $dadosResposta['id'] = $resposta->id; 

            for ($i = 0; $i < count($dadosLabel); $i++) {
                $dadosLabel[$i]['id_resposta'] = $idResposta; 
            }

            $this->formRespostaLabelRepository->salvar($dadosLabel);

            DB::commit();

            $retorno = [];
            $retorno['formulario'] = $formulario;
            $retorno['resposta'] = $dadosResposta;
            $retorno['resposta_labels'] = $dadosLabel;

            return $retorno;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('['.date('Y-m-d H:i:s').'] HTTP CODE: '.$e->getCode().' - MSG: '.$e->getMessage().' - FILE: '.__FILE__);
        
            throw new Exception('Erro no service ao salvar os dados da resposta do formulário.', 500);
        }
    }

    public function listaRespostasLabel($formId)
    {
        $formulario = $this->formRepository->getById($formId);

        if (!$formulario) {
            throw new Exception('Formulário não encontrado', 404);
        }

        $respostas = $this->formRespostaRepository->getRespostasByForm($formulario['id']);

        return $respostas;
    }

    public function listaForm()
    {
        $formularios = $this->formRepository->getLista();

        if (!$formularios) {
            throw new Exception('Formulário não encontrado', 404);
        }

        return $formularios;
    }
}