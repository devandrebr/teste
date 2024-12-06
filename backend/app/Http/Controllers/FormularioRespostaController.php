<?php

namespace App\Http\Controllers;

use App\Services\FormularioService;
use Exception;
use Illuminate\Http\Request;

class FormularioRespostaController extends Controller
{
    protected $formService;

    public function __construct(FormularioService $formService)
    {
        $this->formService = $formService;
    }

    public function cadastro(Request $request, $id_formulario)
    {
        try {
            $request['user_agent'] = $_SERVER['HTTP_USER_AGENT']; 
            $request['endereco_ip'] = $_SERVER['REMOTE_ADDR']; 

            $dados = $this->formService->salvarRespostas($request, $id_formulario);

            return response()->json(['message' => 'Cadastro realizado com sucesso', 'data' => $dados], 201);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $codigoHttp = !$this->validarCodigoHttp((int)$e->getCode()) ? 400 : $e->getCode();

            return response()->json(['message' => $msg], $codigoHttp);
        }
    }

    public function lista($id_formulario, $page = 1)
    {
        try {
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            $dados = $this->formService->listaRespostasLabel($id_formulario, $offset, $limit);

            $dados['page'] = $page;

            return response()->json(['message' => 'Consulta realizada com sucesso', 'data' => $dados]);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $codigoHttp = !$this->validarCodigoHttp((int)$e->getCode()) ? 400 : $e->getCode();

            return response()->json(['message' => $msg], $codigoHttp);
        }
    }
}