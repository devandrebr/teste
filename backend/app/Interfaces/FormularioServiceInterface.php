<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface FormularioServiceInterface
{
    public function salvarRespostas(Request $request, string $formId);
    public function listaRespostasLabel(string $formId, int $offset, int $limit);
    public function listaForm();
}