<?php 
namespace App\Interfaces;

interface FormularioRepositoryInterface
{
    public function getById(string $formId);
    public function getLista();
}