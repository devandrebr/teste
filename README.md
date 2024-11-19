# Descrição de como executar o projeto

A aplicação está expostas nas portas `10212`(api) e `3312`(mysql) usando o Docker, para executar o projeto é necessário realizar o passo a passo abaixo:

1º - Abrir o diretório /backend e criar o arquivo `.env`, duplicando o arquivo `.env.example` e renomeando ele para `.env`

2º - Com o docker aberto, executar o comando: `docker-compose up -d`

3º - Após a criação dos containers, executar o comando do composer `docker exec testegeophp composer install` e depois da migration do Laravel, para criar as tabelas e os registros no banco: `docker exec testegeophp php artisan migrate`

4º - No diretório */postman* tem a collection do Postman para importar e ter os endpoints para fazer os testes

5º - Para executar os testes: `docker exec testegeophp ./vendor/bin/phpunit`

## Preenchimento Formulário

[HTTP: GET] *http://localhost:10212/api/formularios/{id_formulario}/preenchimentos/{pagina}* - Listar os preenchimentos do formulário, onde {id_formulario} na url é o id do formulário e a {pagina} é a página pois cada consulta são retornados 20 registros

[HTTP: POST] *http://localhost:10212/api/formularios/{id_formulario}/preenchimentos* - Cadastrar um novo preenchimento para o formulário - Enviar um json via post com os dados, onde id_formulario é o id do formulário, no payload é preciso informar o id do correto do campo e o texto é o valor da resposta

```json
{
    "fields": [
      {
        "id": "field-1-1", 
        "texto": "Nome Teste Silva"
      },
      {
        "id": "field-1-2",
        "texto": "22"
      },
      {
        "id": "field-1-3",
        "texto": "Sim"
      }
    ]
}
```

## Lista Formulário

[HTTP: GET] *http://localhost:10212/api/formularios/* - Lista todos os formulários