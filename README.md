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

### GET

**_->select()_**
Busca todos registros e todas as colunas de uma tabela, sendo possível especificar uma ou mais coluna dentro do select().

```
   $eventos = DB::table("eventos")->select()->get();

    OR

   $eventos = DB::table("eventos")->select(['coluna_1', 'coluna_2', 'coluna_3'])->get();
```

**_->addSelect()_**
Adiciona uma nova coluna nos registros buscados anteriormente.

```
    $eventos = DB::table("eventos")->select(['title', 'tempo']);
    $eventos->addSelect(['cor', 'local', 'profissional'])->get();
```

**_->first()_**
Busca o primeiro registro que satisfaz a condição.
`$pac = DB::table("pacientes")->where('Nome', 'Felipe')->first();`

**_->value()_**
Busca um único valor na lista de resultados.
`$profissional = DB::table("eventos")->where('id', 5)->value('profissional');`

**_->find()_**
Busca um único registro pela chave primária.
`$evento = DB::table("eventos")->find(10);`

**_->pluck()_**
Retorna uma lista de resultados de uma coluna específica.
`$profissionais = DB::table("eventos")->pluck('profissionais');`

### INSERT/UPDATE

**_->insert()_**
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

**_->insertOrIgnore()_**
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

**_->insertGetId()_**
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

**_->upsert()_**
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

**_->update()_**
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

**_->updateOrInsert()_**
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

**_->increment()/->decrement()_**
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

**_->delete()_**
Remove um registro do banco de dados com base nas condições passadas no `->where()`.
```
    DB::table("pacientes")
        ->where('id', 7)
        ->where('nome', 'Felipe')
        ->delete();
```

**_->truncate()_**
Remove todos registros da tabela.
```
    DB::table("pacientes")
        ->truncate();
```

### MISC

**_->count()_**
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

**_->avg()_**
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

**_->max()_**
Busca o maior valor de uma coluna.
```
    DB::table("pacientes")
        ->max('qtd_atendimentos');
```

**_->min()_**
Busca o menor valor de uma coluna.
```
    DB::table("pacientes")
        ->min('qtd_atendimentos');
```

**_->whereNot()_**
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

**_->whereBetween()_**
Retorna todos os resultados que estão entre os valores passados
```
    DB::table("eventos")
        ->whereBetween('paciente_id', [1, 10])
        ->get();
```

Retorna todos pacientes com id entre 1 e 10

**_->whereNotBetween()_**
Retorna todos os resultados que não estão entre os valores passados
```
    DB::table("eventos")
        ->whereNotBetween('paciente_id', [1, 10])
        ->get();
```

Retorna todos pacientes com id entre 1 e 10

**_->exists()_**
Verifica se existe pelo menos um registro que atenda a condição.
```
    if (DB::table("eventos")->where('retorno', true)->orWhere('paciente_id', 2)->exists()) {
        return true;
    } else {
        return false;
    }
```

**_->doesntExist()_**
Verifica se existe pelo menos um registro que atenda a condição.
```
    if (DB::table("eventos")->where('retorno', true)->orWhere('paciente_id', 2)->doesntexist()) {
        return true;
    } else {
        return false;
    }
```