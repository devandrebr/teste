<?php 
namespace App\Interfaces;

interface FormularioRespostaRepositoryInterface
{
    public function salvar(array $data);
    public function getByForm(string $formId);
    public function getRespostas(int $respostaId);
}