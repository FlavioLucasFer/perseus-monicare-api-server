# Executando a aplicação

## Antes de começar...

Garanta que os seguintes softwares e serviços estejam instalados em seu computador:

- [PHP](https://www.php.net/)
- [PHP Composer](https://getcomposer.org/download/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [MySQL Community Server](https://dev.mysql.com/downloads/mysql/)

****

## 1 - Instalando as dependências

Abra um terminal na raiz do projeto e execute o comando:

```
composer install
```

**Talvez seja necessário atualizar o composer e/ou as dependências do arquivo composer.lock, se for o caso, execute, respectivamente, os seguintes comandos:**

```
composer self-update
composer update
```

## 2 - Criando o banco de dados

Usando uma ferramenta para gerenciar o MySQL (como o [phpMyAdmin](https://www.phpmyadmin.net/)) ou através da linha de comando, crie um banco de dados chamado *monicare* (pode ser dado o nome que quiser para o banco de dados, mas recomendamos usar o nome da aplicação).

## 3 - Configurando o ambiente de desenvolvimento

Note que há um arquivo na raiz do projeto chamado *.env.example*, duplique este arquivo e renomeie a cópia para *.env* apenas.

Agora altere os valores das variáveis *DB_PORT*, *DB_DATABASE*, *DB_USERNAME* e *DB_PASSWORD* conforme necessário. **Note que elas já possuem alguns valores que podem coincidir com as configurações da sua máquina, nesse caso, não precisará alterar**.

## 4 - Rodando as migrations

Antes de rodar as migrations, garanta que seu serviço do MySQL esteja rodando e garanta que o arquivo *.env* esteja devidamente configurado. 

Então, com um terminal aberto na raiz do projeto, execute o comando a seguir para rodar as migrations:

```
php artisan migrate
```

## 5 - Gerando a key para autenticação JWT

A biblioteca resposável por gerar e gerenciar os tokens JWT de autenticação da aplicação necessita que uma key seja gerada.

Para gerar esta key, execute os seguintes comandos, respectivamente:

```
php artisan key:generate
php artisan jwt:secret
```

## 6 - Iniciando o servidor

Agora que tudo está devidamente configurado, execute o comando abaixo para iniciar o servidor:

```
php artisan serve
```

E pronto, a API está rodando.

****

## Informações extras

****

## Proteção das rotas

Atualmente o único middleware de proteção das rotas é o middleware de autenticação, então, para que consiga fazer requisições primeiramente terá que efetuar login através da rota ```/auth/login``` do tipo *post*.

**Mas eu não tenho um usuário, o que faço?** As únicas rotas que não possuem proteção de autenticação, além da rota de login, são as rotas para cadastrar usuário, todas elas do tipo *post*. 

O sistema possui 4 tipos de usuários: doctor (*médico*), healthcare professional (*profissional de saúde*), patient (*paciente*) e caregiver (*cuidador*). 

Sendo assim, para fazer requisições a qualquer rota basta criar um usuário de qualquer um dos tipos mencionados acima e então efetuar login.

## Tempo de duração do token JWT

Os tokens JWT de autenticação duram 1 hora. Caso tenha feito login e o token expire, não precisa efetuar login novamente, basta atualizar o token através da rota ```/auth/refresh``` do tipo *post*.

## Postman Collection e Environment

Caso utilize o Postman, você pode baixar uma *collection* com todas as rotas clicando [aqui](https://drive.google.com/file/d/10Q5Ij8erS4SajcdmbR-PFEPkbAYqp5zl/view?usp=sharing) e baixar um *environment* já configurado clicando [aqui](https://drive.google.com/file/d/1K5bNzhE9chCH1F_XOpaev1pMSbz9WJld/view?usp=sharing).

****

## Não conseguiu iniciar a aplicação?

Caso tenha seguido o passo a passo corretamente e mesmo assim não tenha conseguido iniciar a aplicação, abra um *issue* no repositório que iremos ajudá-lo. 
