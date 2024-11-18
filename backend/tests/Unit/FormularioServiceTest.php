<?php

namespace Tests\Unit;

use App\Services\FormularioService;
use App\Repositories\FormularioRepository;
use App\Repositories\FormularioRespostaRepository;
use App\Repositories\FormularioRespostaLabelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FormularioServiceTest extends TestCase
{
    protected $formService;
    protected $formRepository;
    protected $formRespostaRepository;
    protected $formRespostaLabelRepository;

    public function setUp(): void
    {
        parent::setUp();

        // Mock dos repositórios
        $this->formRepository = $this->mock(FormularioRepository::class);
        $this->formRespostaRepository = $this->mock(FormularioRespostaRepository::class);
        $this->formRespostaLabelRepository = $this->mock(FormularioRespostaLabelRepository::class);

        // Inicializa o serviço com os mocks
        $this->formService = new FormularioService(
            $this->formRepository, 
            $this->formRespostaRepository, 
            $this->formRespostaLabelRepository
        );
    }

    public function testSalvarRespostasSucesso()
    {
        // Dados de exemplo para o formulário
        $formulario = [
            'id' => 1,
            'fields' => [
                [
                    'id' => 'nome',
                    'type' => 'text',
                    'required' => true
                ],
                [
                    'id' => 'email',
                    'type' => 'text',
                    'required' => true
                ]
            ]
        ];

        // Mock da requisição
        $request = new Request([
            'fields' => [
                ['id' => 'field-1-1', 'texto' => 'Teste'],
                ['id' => 'field-1-2', 'texto' => 'teste@teste.com']
            ],
            'user_agent' => 'Mozilla/5.0',
            'endereco_ip' => '127.0.0.1'
        ]);

        // Define o comportamento do mock do repositório FormularioRepository
        $this->formRepository
            ->shouldReceive('getById')
            ->once()
            ->with($formulario['id'])
            ->andReturn($formulario);

        // Define o comportamento do mock do repositório FormularioRespostaRepository
        $this->formRespostaRepository
            ->shouldReceive('salvar')
            ->once()
            ->andReturn((object)['id' => 1]); 

        // Define o comportamento do mock do repositório FormularioRespostaLabelRepository
        $this->formRespostaLabelRepository
            ->shouldReceive('salvar')
            ->once();

        // Executa o método que será testado
        $resultado = $this->formService->salvarRespostas($request, $formulario['id']);

        // Asserções para verificar o resultado
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('formulario', $resultado);
        $this->assertArrayHasKey('resposta', $resultado);
        $this->assertArrayHasKey('resposta_labels', $resultado);
    }

    public function testSalvarRespostasFormularioNaoEncontrado()
    {
        $formId = 1;

        // Define o comportamento do mock do repositório para retornar null
        $this->formRepository
            ->shouldReceive('getById')
            ->once()
            ->with($formId)
            ->andReturnNull();

        // Espera que uma exceção seja lançada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Formulário não encontrado, código incorreto.');
        $this->expectExceptionCode(404);

        // Executa o método que será testado
        $this->formService->salvarRespostas(new Request(), $formId);
    }

    public function testSalvarRespostasValidacaoFalha()
    {
        $formulario = [
            'id' => 1,
            'fields' => [
                [
                    'id' => 'nome',
                    'type' => 'text',
                    'required' => true
                ],
            ]
        ];

        $request = new Request([
            'fields' => [
                ['id' => 'field-1-1', 'texto' => ''], // Campo obrigatório vazio
            ],
            'user_agent' => 'Mozilla/5.0',
            'endereco_ip' => '127.0.0.1'
        ]);

        $this->formRepository
            ->shouldReceive('getById')
            ->once()
            ->with($formulario['id'])
            ->andReturn($formulario);

        // Espera que uma exceção seja lançada devido à validação
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(400); 

        $this->formService->salvarRespostas($request, $formulario['id']);
    }
}
