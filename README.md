
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
  GET /api/items
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Obrigatório**. A chave da sua API |

Registra o usuário para efetuar o login.


#### Login do usuário

```http
  GET /api/items
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Obrigatório**. A chave da sua API |

Efetua o login do usuário.

#### Logout do usuário

```http
  GET /api/items
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Obrigatório**. A chave da sua API |

Efetua o logout do usuário.


#### Retorna todos os itens

```http
  GET /api/items
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Obrigatório**. A chave da sua API |

Lista todos os recursos.

#### Retorna um item

```http
  GET /api/items/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você quer |

Retorna o item especificado.

#### Cria um item

```http
  POST /api/items
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Obrigatório**. A chave da sua API |

Cria um novo item.

#### Atualiza um item

```http
  PUT /api/items/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você quer |

#### add(num1, num2)

Atualiza um novo item.

#### Deleta um item

```http
  DELETE /api/items/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você quer |

#### add(num1, num2)

Remove o item especificado.

