<?php

namespace App\Http\Controllers;

use App\Services\FormularioService;
use Exception;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    protected $formService;

    public function __construct(FormularioService $formService)
    {
        $this->formService = $formService;
    }

    // @todo adicionar limit com offset para paginar o resultado
    public function lista()
    {
        try {
            $dados = $this->formService->listaForm();

            return response()->json(['message' => 'Consulta realizada com sucesso', 'data' => $dados]);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $codigoHttp = !$this->validarCodigoHttp((int)$e->getCode()) ? 500 : $e->getCode();

            return response()->json(['message' => $msg], $codigoHttp);
        }
    }
}