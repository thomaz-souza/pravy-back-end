<p align="center"><a href="https://pravy.com.br" target="_blank"><img src="https://pravy.com.br/wp-content/themes/pravy/assets/images/lgo_pravy.png" width="350" alt="Laravel Logo"></a></p>

## Teste de desenvolvimento Back-end pleno

## Descição

Sistema de login com autenticação de dois fatores (2FA) em LARAVEL via endpoints que permitem logar listar, criar e editar

## Tecnologias utilizadas

- Laravel 11.6.0
- Mysql 8.3
- Laravel/Sanctum
- Laravel/Fortify

## Configuração de ambiente

Pré Requisitos:
- Composer >= 2.5.0
- PHP >= 8.0.1
- MySQL
- Postman

## Dependências do projeto(comandos):

1- Realiza a cópia do projeto:
git clone https://github.com/thomaz-souza/pravy-back-end.git

2- Atualiza e configura os pacotes:
composer update

3- Inicia um servidor em ambiente local [http://localhost:8000]:
php artisan serve

## Configuração do banco de dados

1- Utilizando MySQL command line, após efetuar o login utilize o comando:
create database pravy;

2- Em /config/database.php:
Coloque o usuário e a senha do banco de dados

3- Faça a migração e a população do banco de dados utilizando o comando: 
php artisan migrate --seed

## Variáveis de ambient necessárias

- .env

## Uso da Api - endpoints

Todos os endpoints estão sob o prefixo /user.

Login: POST /login
Desafio 2FA: POST /two-factor-challenge
Registro: POST /register
Endpoints Protegidos (requer autenticação):

Listar Usuários: GET /
Atualizar Usuário: PUT /{user}
Logout: POST /logout

## Coleção Postman 

- [REST API - Users. Pravy](https://www.postman.com/avionics-explorer-17875635/workspace/thomaz-souza/documentation/25436095-4679c239-7a76-45c6-9d2b-11f8311fc8d0)


## Segurança

A segurança de autenticação foi implementada com senha, token temporário, código de acesso e token permanente para a realização de dupla autenticação(2FA)