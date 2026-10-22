# Loja Games

Loja virtual de jogos feita em PHP puro com MySQL/MariaDB, com área administrativa para gerenciar o catálogo.

## Funcionalidades

- Vitrine de jogos com busca por nome
- Login de usuários com senha criptografada (bcrypt)
- Área administrativa restrita a usuários do tipo `admin`
- Cadastro, edição e exclusão de jogos, com upload de imagem

## Tecnologias

- PHP 8 (PDO)
- MySQL / MariaDB
- HTML e CSS
- Docker (opcional)

## Configuração

Copie o arquivo de exemplo e ajuste os dados de acesso ao banco, se necessário:

```
cp .env.example .env
```

```
DB_HOST=172.31.207.149
DB_USER=loja
DB_PASS=123456
DB_NAME=loja_games
```

## Rodando com Docker

```
docker compose up -d
```

- Site: http://localhost:8081
- Banco: `localhost:3308` (usuário e senha do `.env`)

Na primeira execução o banco é criado e populado automaticamente com os arquivos da pasta `banco/`.

Para parar:

```
docker compose down
```

Para apagar o banco e recriar do zero:

```
docker compose down -v
docker compose up -d
```

## Rodando sem Docker

1. Crie o banco importando os arquivos da pasta `banco/`, nesta ordem:
   ```
   mysql -u root -p < banco/01_schema.sql
   mysql -u root -p < banco/02_seed.sql
   ```
2. Crie o usuário do banco com os dados do `.env` (ou altere o `.env` para um usuário existente):
   ```sql
   CREATE USER 'loja'@'%' IDENTIFIED BY '123456';
   GRANT ALL ON loja_games.* TO 'loja'@'%';
   ```
3. Ajuste o `DB_HOST` no `.env` (ex.: `localhost`).
4. Suba o servidor na raiz do projeto:
   ```
   php -S localhost:8000
   ```
   Ou coloque a pasta do projeto no `htdocs` do XAMPP.

Acesse http://localhost:8000

## Usuários de teste

| E-mail | Senha | Tipo |
|---|---|---|
| evandro@gmail.com | J1zPhr9yr0 | admin |
| pedro@gmail.com | vdccWnOk05 | user |

## Estrutura

```
├── index.php              Vitrine
├── login.php              Login
├── logout.php             Logout
├── admin/
│   ├── config/            Conexão com o banco e controle de acesso
│   ├── controllers/       Ações (exclusão)
│   ├── models/            Classes Game e Usuario
│   ├── views/             Telas da área administrativa
│   └── public/            CSS e imagens
├── banco/                 Schema e dados iniciais
├── Dockerfile
└── docker-compose.yml
```
