<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Formulario extends Model
{
    use HasFactory;

    public function registros()
    {
        $arquivo = storage_path('app/form/forms_definition.json');
        if (!file_exists($arquivo))
            throw new Exception('Arquivo .json com as definições do formulário não localizado.', 400);

        $conteudo = file_get_contents($arquivo);
        $json = json_decode($conteudo, true);

        return $json;
    }
}