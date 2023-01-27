# Library
Sistema de gerenciamento de biblioteca que consiste em uma API REST desenvolvida em [Laravel 9](https://laravel.com/docs/9.x) e consumida com [VueJS 3](https://vuejs.org/). O sistema contém gerenciamento de usuários, livros, gêneros e empréstimos. Todos os endpoints da API são testando com [PHPUnit](https://phpunit.de/), além de ter o design pattern repository implementado para manter o código mais limpo, organizado e legível. Essa organização acontece pois esse design pattern cria uma camada a mais de abstração entre o controller e model.

## Instalando o projeto
Esse projeto utiliza a versão 9 do Laravel e a versão 3 do VueJS, então é necessário que você tenha o `PHP >= 8.0` e `Node.js >= 16.0`, assim como as extensões necessárias habilitadas no PHP, que são:

- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

Com o ambiente pronto, você já pode instalar o projeto:
- Clone o repositório do projeto executando o comando `git clone git@github.com:martinsbiel/library.git`
- Entre na pasta do projeto
- Edite o arquivo `.env.example` com as suas credenciais do banco de dados e então renomeie para `.env`
- Execute `composer install` para instalar as dependências do PHP
- Execute `php artisan key:generate` para gerar a chave da aplicação
- Execute `php artisan migrate` para criar as tabelas do banco de dados
- Execute `npm install` para instalar as dependências do frontend
- Execute `php artisan serve` para servir a aplicação
- Execute `npm run dev` para servir o frontend
- Acesse a aplicação pelo navegador `http://localhost:8000/`