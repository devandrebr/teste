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
            // @todo criando...

            $request['user_agent'] = $userAgent; 
            $request['endereco_ip'] = $enderecoIp; 

            $dados = $this->formService->salvarRespostas($request, $id_formulario);

            dd($dados);

            return response()->json(['message' => 'Formulário não encontrado'], 404);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $codigoHttp = (int)$e->getCode() == 0 ? 500 : $e->getCode();

            return response()->json(['message' => $msg], $codigoHttp);
        }
    }

    public function lista($id_formulario)
    {
        try {
            $dados = $this->formService->listaRespostas($id_formulario);

            dd($dados);

            return response()->json(['data' => $dados]);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $codigoHttp = (int)$e->getCode() == 0 ? 500 : $e->getCode();

            return response()->json(['message' => $msg], $codigoHttp);
        }
    }
}