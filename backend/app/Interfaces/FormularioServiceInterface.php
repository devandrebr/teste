<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface FormularioServiceInterface
{
    public function salvarRespostas(Request $request, $formId);
    public function listaRespostasLabel($formId);
    public function listaForm();
}