
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
