# Curso Laravel - Query Build & Eloquent

Este projeto é um curso prático focado na exploração e demonstração das funcionalidades de Query Builder e Eloquent no framework Laravel. Ele serve como um recurso abrangente para entender como interagir com bancos de dados de forma eficiente e elegante usando as ferramentas nativas do Laravel.

## Sumário

1. [Visão Geral do Projeto](#visão-geral-do-projeto)
    - [Objetivo](#objetivo)
    - [Tecnologias Utilizadas](#tecnologias-utilizadas)
    - [Configuração do Ambiente](#configuração-do-ambiente)
2. [Conceitos Fundamentais do Laravel](#conceitos-fundamentais-do-laravel)
    - [Migrations](#migrations)
    - [Factories e Seeders](#factories-e-seeders)
3. [Query Builder](#query-builder)
    - [Introdução ao Query Builder](#introdução-ao-query-builder)
    - [Métodos de Consulta (GET)](#métodos-de-consulta-get)
    - [Métodos de Inserção/Atualização (INSERT/UPDATE)](#métodos-de-inserçãoatualização-insertupdate)
    - [Métodos de Exclusão (DELETE)](#métodos-de-exclusão-delete)
    - [Métodos Diversos (MISC)](#métodos-diversos-misc)
    - [Transações de Banco de Dados](#transações-de-banco-de-dados)
    - [Paginação](#paginação)

## Visão Geral do Projeto

O projeto do curso é uma aplicação monolítica de artigos, onde os usuários podem criar, editar e deletar artigos. O foco principal é demonstrar o uso avançado do Query Builder e do Eloquent ORM do Laravel para manipulação de dados.

### Objetivo

O principal objetivo deste projeto é explorar e aprofundar o conhecimento nas funcionalidades do Laravel, especificamente no uso do Query Builder e do Eloquent. Além disso, o projeto integra o Laravel Breeze para o sistema de autenticação.

### Tecnologias Utilizadas

Para o desenvolvimento deste projeto, foram utilizadas as seguintes tecnologias:

- **Laravel 10**: Framework PHP para desenvolvimento web.
- **Laravel Breeze**: Kit de inicialização para autenticação, scaffolding e outras funcionalidades básicas.
- **Tailwind CSS**: Framework CSS utilitário para estilização rápida e responsiva.
- **Laravel Blade**: Motor de template do Laravel.
- **Laravel Eloquent**: ORM (Object-Relational Mapper) para interação com o banco de dados.

### Configuração do Ambiente

Para rodar o projeto localmente, siga os passos abaixo:

1.  **Clonar o repositório**: `git clone [URL_DO_REPOSITORIO]`
2.  **Instalar dependências**: `composer install`
3.  **Configurar o arquivo `.env`**: Copie o arquivo `.env.example` para `.env` e configure as credenciais do seu banco de dados.
4.  **Criar o banco de dados**: Crie um banco de dados vazio e configure-o no `.env`.
5.  **Rodar as migrations**: `php artisan migrate`
6.  **Rodar os seeders (opcional)**: `php artisan db:seed` (opcional)
7.  **Iniciar o servidor de desenvolvimento**: `php artisan serve`

Certifique-se de que uma instância do banco de dados esteja rodando localmente e que o arquivo `.env` esteja configurado corretamente para que o projeto funcione como esperado.

## Conceitos Fundamentais do Laravel

### Migrations

**O que são Migrations?**

Migrations são arquivos de controle de versão para o seu banco de dados no Laravel. Eles permitem que você modifique o esquema do banco de dados usando código PHP em vez de SQL puro, facilitando o controle de alterações e a colaboração em equipe.

**Como criar Migrations no Laravel?**

Para criar uma nova migration, utilize o comando Artisan:

```bash
php artisan make:migration NOME_DA_MIGRATION
```

É importante notar que o Laravel adiciona automaticamente um prefixo de data e hora (`YYYY_MM_DD_HHmmss`) ao nome da migration, garantindo sua unicidade e ordem cronológica.

**Por que usar as Migrations do Laravel?**

O uso de migrations oferece diversas vantagens:

-   **Controle de Versão**: Permite rastrear e reverter alterações no esquema do banco de dados.
-   **Colaboração**: Facilita o trabalho em equipe, garantindo que todos os desenvolvedores estejam usando a mesma estrutura de banco de dados.
-   **Segurança e Controle**: As alterações são aplicadas de forma mais segura e controlada, minimizando erros.
-   **Portabilidade**: O esquema do banco de dados pode ser facilmente replicado em diferentes ambientes.

**Possibilidades com as Migrations do Laravel**

As migrations permitem uma ampla gama de operações no esquema do banco de dados, incluindo:

-   Unir migrations em um único arquivo de esquema (`php artisan schema:dump`).
-   Modificar colunas existentes (alterar tipo, adicionar restrições).
-   Implementar Soft Deletes para registros.
-   Renomear colunas.
-   Remover colunas.

### Factories e Seeders

**O que são Factories?**

Factories são classes no Laravel que geram dados fictícios para os seus modelos (Models). Elas são extremamente úteis para criar registros falsos para testes automatizados, desenvolvimento local ou para popular o banco de dados com dados de exemplo.

**O que são Seeders?**

Seeders são classes responsáveis por popular o banco de dados com dados iniciais ou de teste. Eles podem utilizar as factories para gerar dados, ou inserir dados diretamente usando o Eloquent ou o Query Builder do Laravel.

## Query Builder

### Introdução ao Query Builder

O Query Builder do Laravel é uma ferramenta poderosa que oferece uma interface fluida e conveniente para criar e executar consultas de banco de dados. Ele permite interagir com o banco de dados de forma mais simples e elegante, sem a necessidade de escrever SQL puro. Com o Query Builder, é possível construir consultas complexas de forma programática, aproveitando a abordagem orientada a objetos do Laravel.

Para utilizar o Query Builder sem o Eloquent, é necessário importar a facade `DB` e acessar o método estático `table()`:

```php
use Illuminate\Support\Facades\DB;

DB::table("NOME_DA_TABELA")
```

### Métodos de Consulta (GET)

Esta seção detalha os métodos utilizados para recuperar dados do banco de dados.

#### `->select()`

Busca todos os registros e todas as colunas de uma tabela. É possível especificar uma ou mais colunas dentro do `select()` para retornar apenas os dados desejados.

```php
// Busca todos os registros e todas as colunas da tabela 'eventos'
$eventos = DB::table("eventos")->select()->get();

// Busca apenas as colunas 'coluna_1', 'coluna_2' e 'coluna_3' da tabela 'eventos'
$eventos = DB::table("eventos")->select(['coluna_1', 'coluna_2', 'coluna_3'])->get();
```

#### `->addSelect()`

Adiciona uma nova coluna aos registros já selecionados anteriormente, permitindo construir consultas com seleção incremental de colunas.

```php
// Seleciona inicialmente as colunas 'title' e 'tempo'
$eventos = DB::table("eventos")->select(['title', 'tempo']);

// Adiciona as colunas 'cor', 'local' e 'profissional' à seleção existente
$eventos->addSelect(['cor', 'local', 'profissional'])->get();
```

#### `->first()`

Busca o primeiro registro que satisfaz uma determinada condição. Este método é útil quando se espera apenas um resultado ou o primeiro de uma lista ordenada.

```php
// Busca o primeiro paciente cujo nome é 'Felipe'
$pac = DB::table("pacientes")->where('Nome', 'Felipe')->first();
```

#### `->value()`

Busca um único valor de uma coluna específica na lista de resultados. Ideal para quando você precisa apenas de um campo de um registro.

```php
// Busca o valor da coluna 'profissional' para o evento com ID 5
$profissional = DB::table("eventos")->where('id', 5)->value('profissional');
```

#### `->find()`

Busca um único registro pela sua chave primária. Este é um método conveniente para recuperar um registro específico quando o ID é conhecido.

```php
// Busca o evento com ID 10
$evento = DB::table("eventos")->find(10);
```

#### `->pluck()`

Retorna uma lista de resultados de uma coluna específica, útil para obter um array simples de valores de uma coluna.

```php
// Retorna uma lista de todos os valores da coluna 'profissionais' da tabela 'eventos'
$profissionais = DB::table("eventos")->pluck('profissionais');
```

### Métodos de Inserção/Atualização (INSERT/UPDATE)

Esta seção aborda os métodos para adicionar e modificar dados no banco de dados.

#### `->insert()`

Adiciona um ou mais registros ao banco de dados. Este método aceita um array de arrays para inserir múltiplos registros de uma vez.

```php
DB::table("eventos")->insert([
    [
        'title' => 'Titulo teste',
        'paciente_id' => 1,
        'profissional' => 'Felipe',
        'codproc' => 2,
        'observacoes' => '',
        'retorno' => false,
    ],
    [
        'title' => 'Titulo teste 2',
        'paciente_id' => 3,
        'profissional' => 'Felipe',
        'codproc' => 6,
        'observacoes' => '',
        'retorno' => true,
    ]
]);
```

#### `->insertOrIgnore()`

Adiciona um ou mais registros ao banco de dados. Caso alguma chave única ou primária seja duplicada, a criação do registro é ignorada, evitando erros de violação de restrição.

```php
DB::table("eventos")->insertOrIgnore([
    [
        'title' => 'Titulo teste',
        'paciente_id' => 1,
        'profissional' => 'Felipe',
        'chave_unica' => 'chave_unica_teste',
        'codproc' => 2,
        'observacoes' => '',
        'retorno' => false,
    ],
    [
        'title' => 'Titulo teste 2',
        'paciente_id' => 3,
        'profissional' => 'Felipe',
        'chave_unica' => 'chave_unica_teste',
        'codproc' => 6,
        'observacoes' => '',
        'retorno' => true,
    ]
]);
```

No exemplo acima, se `chave_unica` for uma chave única e ambos os registros tiverem o mesmo valor, apenas o primeiro será inserido, e o segundo será ignorado.

#### `->insertGetId()`

Adiciona um único registro ao banco de dados e retorna o ID do registro recém-criado. Útil quando você precisa do ID do novo registro imediatamente após a inserção.

```php
$novoEvento = DB::table("eventos")->insertGetId([
    'title' => 'Titulo teste',
    'paciente_id' => 1,
    'profissional' => 'Felipe',
    'chave_unica' => 'chave_unica_teste',
    'codproc' => 2,
    'observacoes' => '',
    'retorno' => false,
]);

return $novoEvento; // Retorna o ID do registro inserido
```

#### `->upsert()`

Atualiza um registro existente ou o cria caso não exista. Este método é ideal para operações de 


upsert (update or insert) em massa, onde você pode especificar as colunas que devem ser usadas para identificar registros duplicados.

```php
DB::table("eventos")->upsert([
    [
        'title' => 'Titulo teste',
        'paciente_id' => 1,
        'profissional' => 'Felipe',
        'chave_unica' => 'chave_unica_teste',
        'codproc' => 2,
        'observacoes' => '',
        'retorno' => false,
    ]
], ['chave_unica']);
```

Este exemplo verifica se já existe um registro com o mesmo valor em `chave_unica`. Se existir, o registro é atualizado; caso contrário, um novo registro é criado.

#### `->update()`

Realiza a atualização de um ou mais registros no banco de dados. Para que a atualização seja aplicada corretamente, é necessário utilizar o método `->where()` para especificar as condições dos registros a serem atualizados.

```php
// Atualiza o registro com ID 3 na tabela 'eventos'
DB::table("eventos")->where(\'id\', 3)
    ->update([
        \'title\' => \'Titulo teste\',
        \'paciente_id\' => 1,
        \'profissional\' => \'Felipe\',
        \'codproc\' => 2,
        \'observacoes\' => \'\',
        \'retorno\' => false,
]);
```

É possível combinar `->where()` com `->orWhere()` para aplicar a atualização a registros que satisfaçam múltiplas condições:

```php
// Atualiza registros com ID 3 OU ID 5 na tabela 'eventos'
DB::table("eventos")->where(\'id\', 3)
    ->orWhere(\'id\', 5)
    ->update([
        \'title\' => \'Titulo teste\',
        \'paciente_id\' => 1,
        \'profissional\' => \'Felipe\',
        \'codproc\' => 2,
        \'observacoes\' => \'\',
        \'retorno\' => false,
]);
```

#### `->updateOrInsert()`

Atualiza um registro se ele existir, ou o cria caso contrário. Diferente do `upsert()`, que pode ser usado para múltiplos registros, `updateOrInsert()` é mais adequado para operações com um único registro.

```php
DB::table("eventos")->updateOrInsert([
    \'title\' => \'Titulo teste\',
    \'paciente_id\' => 1,
    \'profissional\' => \'Felipe\',
    \'chave_unica\' => \'chave_unica_teste\',
    \'codproc\' => 2,
    \'observacoes\' => \'\',
    \'retorno\' => false,
], [\'chave_unica\' => \'teste\']);
```

#### `->increment()` / `->decrement()`

Estes métodos são utilizados para incrementar ou decrementar o valor de uma coluna numérica no banco de dados. A coluna deve ser do tipo `integer` ou similar.

```php
// Incrementa o campo 'atendimentos_realizados' em 1 para o paciente com ID 7
DB::table("pacientes")->where(\'id\', 7)
    ->increment(\'atendimentos_realizados\', 1);
```

O primeiro parâmetro é o nome da coluna a ser alterada, e o segundo é o valor a ser incrementado ou decrementado.

É possível incrementar ou decrementar múltiplas colunas simultaneamente com `incrementEach()`:

```php
// Incrementa 'atendimentos_realizados' e 'mensagens_enviadas' em 1 para o paciente com ID 7
DB::table("pacientes")->where(\'id\', 7)
    ->incrementEach([\'atendimentos_realizados\', \'mensagens_enviadas\'], 1);
```

### Métodos de Exclusão (DELETE)

Esta seção descreve os métodos para remover dados do banco de dados.

#### `->delete()`

Remove um ou mais registros do banco de dados com base nas condições especificadas pelo método `->where()`.

```php
// Remove o paciente com ID 7 E nome 'Felipe'
DB::table("pacientes")
    ->where(\'id\', 7)
    ->where(\'nome\', \'Felipe\')
    ->delete();
```

#### `->truncate()`

Remove todos os registros de uma tabela, redefinindo o auto-incremento. É uma operação mais rápida que `delete()` para remover todos os dados.

```php
// Remove todos os registros da tabela 'pacientes'
DB::table("pacientes")
    ->truncate();
```

### Métodos Diversos (MISC)

Esta seção apresenta métodos variados para operações comuns de banco de dados.

#### `->count()`

Conta o número de registros que satisfazem uma determinada condição. Se nenhuma condição for especificada, conta todos os registros da tabela.

```php
// Conta todos os eventos na tabela
DB::table("eventos")
    ->count();

// Conta eventos onde 'retorno' é verdadeiro
DB::table("eventos")
    ->where(\'retorno\', true)
    ->count();
```

#### `->avg()`

Calcula a média de uma coluna numérica com base nos resultados retornados. Pode-se especificar a coluna para a qual a média será calculada.

```php
// Calcula a média de uma coluna padrão para eventos do profissional 'Felipe'
DB::table("eventos")
    ->where(\'profissional\', \'Felipe\')
    ->avg();

// Calcula a média da coluna 'qtd_atendimentos' para pacientes
DB::table("pacientes")
    ->avg(\'qtd_atendimentos\');
```

#### `->max()`

Busca o maior valor de uma coluna específica.

```php
// Busca o maior valor da coluna 'qtd_atendimentos' para pacientes
DB::table("pacientes")
    ->max(\'qtd_atendimentos\');
```

#### `->min()`

Busca o menor valor de uma coluna específica.

```php
// Busca o menor valor da coluna 'qtd_atendimentos' para pacientes
DB::table("pacientes")
    ->min(\'qtd_atendimentos\');
```

#### `->whereNot()`

Funciona de forma similar ao `->where()`, mas retorna os registros que *não* satisfazem a condição especificada.

```php
// Retorna eventos onde 'retorno' NÃO é verdadeiro
DB::table("eventos")
    ->whereNot(\'retorno\', true)
    ->get();
```

Também é possível usar `orWhereNot()` para adicionar uma condição 


OR que *não* satisfaz a condição:

```php
// Retorna eventos onde (
//   (\'retorno\' é verdadeiro)
//   OU
//   (\'paciente_id\' NÃO é 2)
// )
DB::table("eventos")
    ->where(\'retorno\', true)
    ->orWhereNot(\'paciente_id\', 2)
    ->get();
```

#### `->whereBetween()`

Retorna todos os registros onde o valor de uma coluna está entre dois valores especificados (inclusive).

```php
// Retorna eventos onde \'paciente_id\' está entre 1 e 10
DB::table("eventos")
    ->whereBetween(\'paciente_id\', [1, 10])
    ->get();
```

#### `->whereNotBetween()`

Retorna todos os registros onde o valor de uma coluna *não* está entre dois valores especificados.

```php
// Retorna eventos onde \'paciente_id\' NÃO está entre 1 e 10
DB::table("eventos")
    ->whereNotBetween(\'paciente_id\', [1, 10])
    ->get();
```

#### `->exists()`

Verifica se existe pelo menos um registro que atenda à condição especificada, retornando `true` ou `false`.

```php
if (DB::table("eventos")->where(\'retorno\', true)->orWhere(\'paciente_id\', 2)->exists()) {
    return true;
} else {
    return false;
}
```

#### `->doesntExist()`

Verifica se *não* existe nenhum registro que atenda à condição especificada, retornando `true` ou `false`.

```php
if (DB::table("eventos")->where(\'retorno\', true)->orWhere(\'paciente_id\', 2)->doesntExist()) {
    return true;
} else {
    return false;
}
```

#### `->chunk()`

Quebra uma consulta grande em pedaços menores (chunks) e processa cada pedaço individualmente. Isso é extremamente útil para economizar memória ao lidar com grandes volumes de dados, pois o Laravel carrega apenas uma parte dos resultados por vez.

```php
// Exemplo de uma consulta que pode retornar muitos resultados
DB::table("eventos")->where("paciente_id", 3)->get();
```

Se o paciente com ID 3 tiver 500 mil consultas, o uso de `chunk()` pode otimizar o processamento:

```php
DB::table("eventos")->where("paciente_id", 3)->chunk(1000, function ($eventos) {
    foreach ($eventos as $evento) {
        // Lógica para manipular cada evento dentro do chunk
    }
});
```

Neste exemplo, a consulta é dividida em blocos de 1000 registros, e a função de callback é executada para cada bloco.

#### `->latest()` / `->oldest()`

Estes métodos são usados para ordenar os resultados da consulta. Por padrão, eles ordenam pela coluna `created_at`. `latest()` ordena do mais recente para o mais antigo, e `oldest()` do mais antigo para o mais recente.

```php
// Ordena eventos do mais recente para o mais antigo
DB::table("eventos")->latest()->get();

// Ordena eventos do mais antigo para o mais recente
DB::table("eventos")->oldest()->get();
```

#### `->when()`

Permite aplicar condições à consulta de forma condicional. A função de callback é executada apenas se a condição for verdadeira.

```php
DB::table("eventos")->when(function($query) {
    return $query->where(\'retorno\', true);
})->get();
```

### DATABASE TRANSACTIONS

Uma transação de banco de dados é um bloco de operações que são executadas como uma única unidade atômica. Isso significa que, se todas as operações dentro da transação forem bem-sucedidas, as alterações são salvas (commit). No entanto, se qualquer operação falhar, todas as alterações feitas dentro da transação são desfeitas (rollback), garantindo a integridade e consistência dos dados.

**Por que usar Transações?**

Transações são cruciais para garantir a consistência dos dados em operações críticas, como:

-   **Transferência de dinheiro**: Garante que o débito de uma conta e o crédito em outra ocorram simultaneamente ou que nenhuma das operações seja registrada.
-   **Criação de registros relacionados**: Por exemplo, ao criar um pedido e seus itens, todas as inserções devem ser bem-sucedidas para que o pedido seja válido.
-   **Processos multi-etapas**: Qualquer processo que envolva múltiplas tabelas ou etapas interdependentes se beneficia do uso de transações para evitar estados inconsistentes.

**Como usar Transações no Laravel?**

No Laravel, as transações são gerenciadas facilmente com o método `DB::transaction()`:

```php
DB::transaction(function () {
    DB::table("eventos")
        ->where("paciente_id", "5")
        ->update(["retorno" => true]);
    
    DB::table("pacientes")
        ->where("paciente_id", 5)
        ->decrement("atendimentos_realizados", 5);
});
```

Neste exemplo, ambas as operações de atualização serão executadas. Se a primeira falhar, a segunda não será executada e a primeira será revertida. Se a segunda falhar, a primeira também será revertida.

#### Pessimistic Locking

Pessimistic Locking é uma técnica de controle de concorrência utilizada para bloquear outros processos de ler ou escrever a mesma linha no banco de dados enquanto uma transação está em andamento. No Laravel, isso é implementado através dos métodos `lockForUpdate()` e `sharedLock()`.

**Por que usar Pessimistic Locking?**

É fundamental em cenários onde múltiplos processos (ou usuários) podem tentar atualizar o mesmo recurso simultaneamente, como o estoque de um produto ou o saldo de uma conta bancária. Sem um controle adequado, isso pode levar a inconsistências nos dados.

-   **Sem controle**: Dois processos leem o valor original (ex: estoque = 10). Ambos fazem alterações simultâneas. O valor final pode estar incorreto (ex: estoque deveria ser 8, mas ficou 9).
-   **Com Pessimistic Locking**: O primeiro processo bloqueia a linha. O segundo processo espera até que o bloqueio seja liberado ou falha, evitando conflitos e garantindo a integridade dos dados.

**Como usar Pessimistic Locking no Laravel?**

##### `lockForUpdate()`

Este método impede que outros processos leiam ou escrevam na mesma linha até que a transação atual seja concluída. É o tipo de bloqueio mais restritivo.

```php
DB::transaction(function () {
    DB::table("pacientes")
        ->where("paciente_id", 5)
        ->lockForUpdate()
        ->first();
    
    DB::table("pacientes")
        ->where("paciente_id", 5)
        ->decrement("atendimentos_realizados", 5);
});
```

##### `sharedLock()`

Permite que outros processos leiam a linha, mas impede que a escrevam até que a transação atual seja concluída. É menos restritivo que `lockForUpdate()`.

```php
DB::transaction(function () {
    DB::table("pacientes")
        ->where("paciente_id", 5)
        ->sharedLock()
        ->first();
});
```

### PAGINAÇÃO

Paginação é o processo de dividir uma grande massa de dados em páginas menores e mais gerenciáveis, melhorando a performance e a experiência do usuário ao exibir grandes conjuntos de resultados.

#### `->paginate()`

Divide os resultados da consulta em páginas. Este método é mais completo, pois além de retornar os dados da página atual, também fornece informações sobre o total de registros, o número da última página, etc., o que é útil para construir links de paginação completos.

```php
->paginate($perPage = null, $columns = [\'*\'], $pageName = \'page\')
```

-   **Primeiro parâmetro**: `perPage` (opcional) - Quantidade de registros por página. Se `null`, o Laravel usa um valor padrão.
-   **Segundo parâmetro**: `columns` (opcional) - Array de colunas a serem retornadas. Por padrão, retorna todas as colunas (`['*']`).
-   **Terceiro parâmetro**: `pageName` (opcional) - Nome da variável de query string usada para indicar o número da página (ex: `?page=2`). O padrão é `'page'`.

```php
// Pagina a tabela \'pacientes\' com 5 registros por página, retornando todas as colunas
// e usando \'pacientes\' como nome da variável de página na URL.
DB::table("pacientes")
    ->paginate(5, [\'*\'], \'pacientes\')
    ->get();
```

#### `->simplePaginate()`

Uma alternativa mais eficiente ao `paginate()` para casos onde você precisa apenas de links 


de "Próximo" e "Anterior". Ele é mais leve porque não conta o total de registros, economizando uma consulta extra ao banco de dados. Aceita os mesmos parâmetros do `paginate()`.

```php
// Pagina a tabela \'pacientes\' com 5 registros por página, usando simplePaginate
DB::table("pacientes")
    ->simplePaginate(5)
    ->get();
```


