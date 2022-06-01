
# Setup Docker 
[Fonte DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose-on-ubuntu-20-04)

### Passo a passo



Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env


Suba os containers do projeto
```sh
docker-compose up -d
```

Instalar as dependências do projeto
```sh
docker-compose exec app composer install
```

Gerar a key do projeto Laravel
```sh
docker-compose exec app php artisan key:generate
```

Aplicar as migraçõe do banco de dados
```sh
docker-compose exec app php artisan migrate
```


Acesse o projeto
[http://localhost:8180](http://localhost:8180)


# Setup Plugin Artisan.io

Criar um arquivo csv com os dados
```sh
John Doe,john.doe@example.com,123456789
Jane Doe,jane.doe@example.com,12345678
Jane1 Doe,jane1.doe@example.com,12345678
```

Fazer o upsert dos dados
```sh
docker-compose exec app \
     php artisan import:delimited \
     user.csv "\App\Models\User" \
     -f name:0,email:1,password:2 \
     -k email 
```

Documetação https://github.com/pmatseykanets/artisan-io


# Setup jQuery

Rodar o comando
```sh
npm i install
```

Colar a linha abaixo em resources/js/bootstrap.js
```sh
window.$ = require('jquery'); 
```
