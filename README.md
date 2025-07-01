# Curso Laravel - Query Build & Eloquent

## Migrations

**O que são Migrations?**

Migrations são arquivos dentro da aplicação que permite modificar o schema do database usando o PHP em vez de SQL.

**Como criar migrations no Laravel?**

Pela CLI rodar o comando: `php artisan make:migration NOME_DA_MIGRATION`. Importante ressaltar que o nome da migration por padrão vai seguir o formato. YYYY_MM_DD_HHmmss_NOME_DA_MIGRATION

**Por que usar as migrations do Laravel?**

As migrations permite que você faça alterações no schema do banco de dados de forma mais segura e controlada.

**Possibilidades com as migrations do Laravel**

- Unir migrations em um schema `php artisan schema:dump`
- Modificar colunas já existentes
- Soft Delete
- Renomear colunas
- Dropa colunas

## Factories e Seeders

**O que são factories?**

São classes que gerão dados fictícios para os models do Laravel, usado para criar registros falsos para testes ou durante o desenvolvimento.

**O que são seeders?**

São classes que executam a criação de dados no banco, pode usar as factories, Eloquent ou DB direto.

## Query Builder

**O que é o query builder do Laravel?**

O Laravel possui muitas classes e métodos que permitem que você interaja com o banco de dados de forma mais simples e elegante. Uma boa alternativa ao invés de escrever queries com SQL puro e proporciona uma abordagem mais voltada ao POO para performar operações no banco de dados. Também permite a utilização de mais de um método para queries mais complexas.

**Como utilizar os métodos do Laravel?**

Caso não esteja utilizando o Eloquent será necessário importar a facade DB e acessar o método estático table do DB
`DB::table("NOME_DA_TABELA")`

## Métodos do Query Builder do Laravel

1. [GET](#get)
    - ->select()
    - ->addSelect()
    - ->first()
    - ->value()
    - ->find()
    - ->pluck()
2. [INSERT/UPDATE](#insertupdate)
    - ->insert()
    - ->insertOrIgnore()
    - ->insertGetId()
    - ->upsert()
    - ->update()
    - ->updateOrInsert()
    - ->increment()/->decrement()
3. [DELETE](#delete)
    - ->delete()
    - ->truncate()
4. [MISC](#misc)
    - ->count()
    - ->avg()
    - ->max()
    - ->min()
    - ->whereNot()
    - ->whereBetween()
    - ->whereNotBetween()
    - ->exists()
    - ->doesntExist()
### GET

**_->select()_** <br>
Busca todos registros e todas as colunas de uma tabela, sendo possível especificar uma ou mais coluna dentro do select().

```
   $eventos = DB::table("eventos")->select()->get();

    OR

   $eventos = DB::table("eventos")->select(['coluna_1', 'coluna_2', 'coluna_3'])->get();
```

**_->addSelect()_** <br>
Adiciona uma nova coluna nos registros buscados anteriormente.

```
    $eventos = DB::table("eventos")->select(['title', 'tempo']);
    $eventos->addSelect(['cor', 'local', 'profissional'])->get();
```

**_->first()_** <br>
Busca o primeiro registro que satisfaz a condição.
```
    $pac = DB::table("pacientes")->where('Nome', 'Felipe')->first();
```

**_->value()_** <br>
Busca um único valor na lista de resultados.
```
    $profissional = DB::table("eventos")->where('id', 5)->value('profissional');
```

**_->find()_** <br>
Busca um único registro pela chave primária.
```
    $evento = DB::table("eventos")->find(10);
```

**_->pluck()_** <br>
Retorna uma lista de resultados de uma coluna específica.
```
    $profissionais = DB::table("eventos")->pluck('profissionais');
```

### INSERT/UPDATE

**_->insert()_** <br>
Adiciona um ou mais registro no banco de dados.
```
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

**_->insertOrIgnore()_** <br>
Adiciona um ou mais registro no banco de dados, porém caso alguma chave única ou primária seja duplicada ignora a criação do registro no banco.
```
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
Num cenário onde chave_unica é uma chave única e eles estão com o mesmo valor, faria a criação da primeira ocorrência e na segunda ignoraria a criação.

**_->insertGetId()_** <br>
Adiciona um registro no banco de dados, retornando o ID do registro criado.
```
    $novoEvento = DB::table("eventos")->insertGetId([
            'title' => 'Titulo teste',
            'paciente_id' => 1,
            'profissional' => 'Felipe',
            'chave_unica' => 'chave_unica_teste',
            'codproc' => 2,
            'observacoes' => '',
            'retorno' => false,
        ]);

    return $novoEvento;
```

**_->upsert()_** <br>
Faz o update de um registro e caso não exista cria o registro  no banco de dados.
```
    DB::table("eventos")->upsert([
            'title' => 'Titulo teste',
            'paciente_id' => 1,
            'profissional' => 'Felipe',
            'chave_unica' => 'chave_unica_teste',
            'codproc' => 2,
            'observacoes' => '',
            'retorno' => false,
    ], ['chave_unica']);
```
Verifica se já existe um registro com o mesmo valor de chave_unica, caso exista faz o update caso não exista cria no banco.

**_->update()_** <br>
Faz o update de um registro no banco de dados. Para realizar o update necessário utilizar o método `->where()`.
```
    DB::table("eventos")->where('id', 3)
        ->update([
            'title' => 'Titulo teste',
            'paciente_id' => 1,
            'profissional' => 'Felipe',
            'codproc' => 2,
            'observacoes' => '',
            'retorno' => false,
    ]);
```
Também é possivel usar o método `->orWhere()` que vai verificar se o registro existe com base na outra condição passada.
```
    DB::table("eventos")->where('id', 3)
        ->orWhere('id', 5)
        ->update([
            'title' => 'Titulo teste',
            'paciente_id' => 1,
            'profissional' => 'Felipe',
            'codproc' => 2,
            'observacoes' => '',
            'retorno' => false,
    ]);
```

**_->updateOrInsert()_** <br>
Faz o update de um registro no banco de dados caso ele exista se não existir ele cria o registro.
```
    DB::table("eventos")->updateOrInsert([
            'title' => 'Titulo teste',
            'paciente_id' => 1,
            'profissional' => 'Felipe',
            'chave_unica' => 'chave_unica_teste',
            'codproc' => 2,
            'observacoes' => '',
            'retorno' => false,
    ], ['chave_unica' => 'teste']);
```
Existe uma diferença entre o updateOrInsert() e o upsert(), o upsert serve para um ou mais registros , o updateOrInsert serve para um registro.

**_->increment()/->decrement()_** <br>
Faz o incremento ou decremento de um campo no banco de dados. Para realizar o increment o ou decremento necessário a coluna ser do tipo integer
```
    DB::table("pacientes")->where('id', 7)
        ->increment('atendimentos_realizados', 1);
```
método recebe no primeiro parametro a coluna que vai ser alterada e no segundo parametro o valor que vai incrementar ou decrementar.

```
    DB::table("pacientes")->where('id', 7)
        ->incrementEach(['atendimentos_realizados', 'mensagens_enviadas'], 1);
```
também é possível incrementar ou decrementar mais de uma coluna ao mesmo tempo.

### DELETE

**_->delete()_** <br>
Remove um registro do banco de dados com base nas condições passadas no `->where()`.
```
    DB::table("pacientes")
        ->where('id', 7)
        ->where('nome', 'Felipe')
        ->delete();
```

**_->truncate()_** <br>
Remove todos registros da tabela.
```
    DB::table("pacientes")
        ->truncate();
```

### MISC

**_->count()_** <br>
Conta o número de registros encotrados com a condição passada.
```
    DB::table("eventos")
        ->count();
```
Retorna todos os eventos que estão na tabela
```
    DB::table("eventos")
        ->where('retorno', true)
        ->count();
```
Retorna todos eventos que estão com retorno como true

**_->avg()_** <br>
Calcula a média com base nos resultados retornados
```
    DB::table("eventos")
        ->where('profissional', 'Felipe')
        ->avg();
```
Também é possível especificar uma coluna para calcular a média
```
    DB::table("pacientes")
        ->avg('qtd_atendimentos');
```

**_->max()_** <br>
Busca o maior valor de uma coluna.
```
    DB::table("pacientes")
        ->max('qtd_atendimentos');
```

**_->min()_** <br>
Busca o menor valor de uma coluna.
```
    DB::table("pacientes")
        ->min('qtd_atendimentos');
```

**_->whereNot()_** <br>
Funciona como `->where()` porém em vez de trazer os resultados que estão com a condição, traz os que não estão.
```
    DB::table("eventos")
        ->whereNot('retorno', true)
        ->get();
```
Também é possível adicionar o `orWhereNot()` que tem a mesma função sendo um orWhere a mais apenas.
```
    DB::table("eventos")
        ->where('retorno', true)
        ->orWhereNot('paciente_id', 2)
        ->get();
```

**_->whereBetween()_** <br>
Retorna todos os resultados que estão entre os valores passados
```
    DB::table("eventos")
        ->whereBetween('paciente_id', [1, 10])
        ->get();
```

Retorna todos pacientes com id entre 1 e 10

**_->whereNotBetween()_** <br>
Retorna todos os resultados que não estão entre os valores passados
```
    DB::table("eventos")
        ->whereNotBetween('paciente_id', [1, 10])
        ->get();
```

Retorna todos pacientes que o id não está entre 1 e 10

**_->exists()_** <br>
Verifica se existe pelo menos um registro que atenda a condição.
```
    if (DB::table("eventos")->where('retorno', true)->orWhere('paciente_id', 2)->exists()) {
        return true;
    } else {
        return false;
    }
```

**_->doesntExist()_** <br>
Verifica se existe pelo menos um registro que atenda a condição.
```
    if (DB::table("eventos")->where('retorno', true)->orWhere('paciente_id', 2)->doesntexist()) {
        return true;
    } else {
        return false;
    }
``` 

**_->chunk()_** <br>
Quebra uma consulta grande em pedaços menores e processa um pedaço por vez, visando economizar memória. Usando o método chunk() o laravel quebra a consulta com LIMIT e OFFSET e processa um bloco, finalizando ele passa pro próximo, pode ser de extrema valia em consultas com dados muito grandes.

```
    DB::table("eventos")->where("paciente_id", 3)->get();
```
Num cenário onde o paciente com id 3 tem 500mil consultas, pode-se usar o chunk para quebrar essa consulta em blocos de tamanho variado e processar esses blocos individualmente, economizando memória.

```
    DB::table("eventos")->where("paciente_id", 3)->chunk(1000, function ($eventos) {
        foreach ($eventos as $evento) {
            <!-- Permite manipular a variavel $evento -->
        }
    });
```

**_->latest()/->oldest()_** <br>
Ordenação dos resultados, se não passar nenhum parametro é validado o campo "created_at" para ordenação. <br>

Mais recentes
```
    DB::table("eventos")->latest()->get();
```

Mais antigos
```
    DB::table("eventos")->oldest()->get();
```

**_->when()_** <br>
Método usado para condicionar o retorno dos registros

```
    DB::table("eventos")->when(function($query) {
        return $query->where('retorno', true)
    })->get();
```

### DATABASE TRANSACTIONS

É um bloco de operações executadas como uma única unidade. Se **todas** operações dentro da transação for bem sucedidas, os dados são salvos, caso qualquer uma falhar é tudo revertido. <br>

**Por que usar as transações?** <br>
Para garantir consistência dos dados em operações críticas, como:
- Transferência de dinheiro;
- Criação de registros relacionados (ex: pedido e itens do pedido);
- Qualquer processo onde várias tabelas ou etapas estejam envolvidas.

**Como usar as transações no laravel?** <br>
Usando o método `DB::transaction()`. 

```
    DB::transaction(function () {
        DB::table("eventos")
            ->where("paciente_id", "5")
            ->update(["retorno" => true]);
        
        DB::table("pacientes")
            ->where("paciente_id", 5)
            ->decrement("atendimentos_realizados", 5);
    })
```

**Pessimistic Locking** <br>
É uma técnica de controle de concorrência usada para bloquear outros processos de ler ou escrever a mesma linha no banco de dados. No laravel é usado os métodos:
- `lockForUpdate()`
- `sharedLock()`

**Por que usar o Pessimistic Locking?** <br>
Caso exista 2 processos (ou usuários) tentando atualizar o mesmo recurso ao mesmo tempo, como o estoque de um produto ou saldo de uma conta.

**_Sem controle:_**

- Os dois leem o valor original (ex: estoque = 10)
- Ambos fazem alterações simultâneas
- O valor final pode acabar incorreto (ex: estoque deveria ser 8, mas ficou 9)

**_Com pessimistic locking:_**

- O primeiro processo bloqueia a linha
- O segundo espera ou falha, evitando conflito

**Como usar o Pessimistic Locking no Laravel?** <br>

**_lockForUpdate()_** <br>
Impede que outros leiam ou escrevam a mesma linha até que a transação acabe.
```
    DB::transaction(function () {
        DB::table("pacientes")
            ->where("paciente_id", 5)
            ->lockForUpdate()
            ->first();
        
        DB::table("pacientes")
            ->where("paciente_id", 5)
            ->decrement("atendimentos_realizados", 5);
    })
```

**_sharedLock()_** <br>
Permite leitura por outros, mas bloqueia escrita.
```
    DB::transaction(function () {
        DB::table("pacientes")
            ->where("paciente_id", 5)
            ->sharedLock()
            ->first();
    })
```

### PAGINAÇÃO

**_paginate()_** <br>
Divide uma grande massa de dados em páginas menores. 
```->paginate($perPage = null, $columns = ['*'], $pageName = 'page')```

- Primeiro parametro: quantidade por página
- Segundo parametro: colunas retornadas
- Terceiro parametro: nome da variável de página

```
    DB::table("pacientes")
        ->paginate(5, ['*'], 'pacientes')
        ->get();
```

**_simplePaginate()_** <br>
Divide uma grande massa de dados em páginas menores, mais eficiente que o paginate pois usa menos memória, isso porque o simplePaginate só carrega os dados da página atual, enquanto o paginate carrega todos os dados. Aceita os mesmos parametros do paginate()
```
    DB::table("pacientes")
        ->simplePaginate(5)
        ->get();
```