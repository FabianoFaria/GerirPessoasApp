
# Gestão de pessoas Rest API

Aplicativo com objetivo de gerenciar os recurso pessoas.
Onde o usuário efetua o cadastro e login, então efetua o CRUD de resursos Pessoas

## Pré requisitos para Instalação

Ter instalado no ambiente de deploy, as seguintes tecnologias: 

- Docker Engine
    Documentação e download: https://docs.docker.com/engine/

- Docker Compose
    Documentação e download: https://docs.docker.com/compose/install/

## Instalação

Após clonar o projeto, configurar as variaveis de ambiente no arquivo .env

```bash
    cp .env.example .env
```
- Editar o arquivo .env com o editor de sua preferência, neste arquivo, configurar principalmente as variaveis de configuração do aplicativo, as credenciais de banco de dados.

- Obs: Como este projeto foi desenvolvido para integrar dados com o Postgres Sql, é apropriado configurar o .env com os dados configurados no docker-composer.yml

- Obs 2: Ainda no arquivo .env, nomear o DB_HOST com o mesmo nome que a imagem do Postgres configurada no docker-compose.yml (Ex: 'DB_HOST=postgres')
Após as configuraçõe no arquivo .env, efetuar a compilação da imagem do aplicativo

```bash
    docker-compose build app
```

Com a compilação comcluida, executar o ambiente, de preferência em segundo plano.

```bash
    docker-compose up -d
```

Verificar se os contêineres foram gerados corretamente

```bash
    docker-compose ps
```

Após o ambiente estar rodando, iniciar o laravel

```bash
    docker-compose exec -u root app composer install
```

Então, gerar uma chave única para o aplicativo

```bash
    docker-compose exec -u root app php artisan key:generate
```

Agora, vá até seu navegador e acesse o nome de domínio ou endereço IP do seu servidor na porta especificada no arquivo .env (Ex: http://localhost:8100/ )

Gerar, atualizar, derrubar tabelas do banco de dados do postgres

```bash
    docker-compose exec -u root app php artisan migrate
```

'Semear' as tabelas de banco de dados geradas.

```bash
    docker-compose exec -u root app php artisan db:seed
```

## Documentação da API

#### Cadastro do usuário

```http
  POST /api/register
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **Obrigatório**. Nome para identificação do usuário |
| `email` | `string` | **Obrigatório**. Email utilizado para o login |
| `password` | `string` | **Obrigatório**. Senha usada para o usuário efetua o login |


#### Login do usuário

```http
  POST /api/login
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. Email utilizado para o login |
| `password` | `string` | **Obrigatório**. Senha usada para o usuário efetua o login |

#### Logout do usuário

```http
  POST /api/logout
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `token` | `string` | **Obrigatório**. Token necessário para efetuar o processo de logout. |

Efetua o logout do usuário.


#### Retorna todos os itens

```http
  GET /api/pessoas
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| Nenhum parametro necessário |


#### Retorna um item

```http
  GET /api/pessoas/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID da pessoa selecionada |


#### Cria um item

```http
  POST /api/pessoas
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `pessoa_nome` | `string` | **Obrigatório**. Nome do recurso pessoa a ser cadastrado. |


#### Atualiza um item

```http
  PUT /api/pessoas/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`          | `int` | **Obrigatório**. O ID do item que você quer |
| `pessoa_nome` | `string` | **Obrigatório**. O novo nome do recurso pessoa |


#### Deleta um item

```http
  DELETE /api/pessoas/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do item que você quer |



## Referência das tecnologias utilizadas até o momento nesse projeto

 - [Docker Engine](https://docs.docker.com/engine/)
 - [Docker Compose](https://docs.docker.com/compose/)
 - [PHP](https://www.php.net)
 - [Compose](https://getcomposer.org)
 - [Laravel](https://laravel.com)
 - [Nginx](https://www.nginx.com)
 - [Postgress](https://www.postgresql.org)




