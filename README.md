# Documentação da API - Laravel

Este documento fornece uma visão geral e instruções para utilizar a API construída com Laravel 10 e PHP 8.2. Destaca-se a adoção do padrão CQRS para a segregação da lógica.

## Visão Geral

A API é construída com o framework Laravel 10, que é conhecido por sua elegância, simplicidade e eficiência. Além disso, a versão 8.2 do PHP é utilizada para garantir um desempenho e segurança otimizados.

## Padrão CQRS

O padrão CQRS (Command Query Responsibility Segregation) é adotado nesta API para separar as operações de leitura (queries) das operações de escrita (commands). Isso permite uma melhor organização e escalabilidade do código, facilitando a manutenção e a adição de novas funcionalidades.

## Estrutura do Projeto

A estrutura do projeto Laravel segue as convenções padrão do framework, com os principais diretórios e arquivos sendo:

- `app/`: Contém os modelos, controladores e outros artefatos da aplicação.
- `database/`: Contém as migrações de banco de dados, seeds e factories.
- `routes/`: Contém os arquivos de definição de rotas da API.
- `config/`: Contém os arquivos de configuração da aplicação.
- `src/Core`: Contém definições de interface do nucleo do sistema, como comandos, queries, erros, e leitura de arquivos.

Além disso, o projeto é dividido em módulos, cada um podendo conter seus próprios comandos, queries, modelos, jobs, recursos de lingua e outros. Os módulos são organizados no diretório `src/Modules`.

- `src/Modules/Contact`: Contém os comandos, queries, modelos e outros artefatos relacionados ao módulo de contato.

- `src/Modules/Sheet`: Contém as classes concretas para a leitura de arquivos csv.

## Endpoints Principais

A API oferece os seguintes endpoints principais:

1. `[post] api/v1/contacts/upload-csv`: Endpoint para realizar o upload de um arquivo CSV contendo informações de contato para notificação em massa.
2. `[get] api/v1/contacts/notifications`: Endpoint para listar as notificações de contato pendentes.
3. `[put] api/v1/contacts/notifications`: Endpoint para editar as notificações de contato pendentes.

## Autenticação e Autorização

Para o escopo deste projeto a autenticação e autorização não foram implementadas. No entanto, é possível adicionar esses recursos utilizando o Laravel Passport ou outras bibliotecas de autenticação.

## Documentação Adicional

Para mais detalhes sobre como utilizar os endpoints da API, consulte a documentação oficial do Laravel em [https://laravel.com/docs](https://laravel.com/docs).


## Licença

Esta API é licenciada sob a [Licença MIT](https://pt.wikipedia.org/wiki/Licen%C3%A7a_MIT).
