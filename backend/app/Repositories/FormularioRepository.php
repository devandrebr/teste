<?php

namespace App\Repositories;

use App\Interfaces\FormularioRepositoryInterface;
use App\Models\Formulario;

class FormularioRepository implements FormularioRepositoryInterface
{
    public function getById(string $id)
    {
        $form = new Formulario();
        $formularios = $form->registros();

        $formulario = collect($formularios)->firstWhere('id', $id);

        return $formulario;
    }
}