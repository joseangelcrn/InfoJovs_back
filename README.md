# InfoJovs (v of Vue) || Backend Side of [InfoJovs_front](https://github.com/joseangelcrn/InfoJovs_front)
 
## An infojobs app based (in progress..) 

## Setup 

```
cd InfoJovs_back
cp .env.example .env
composer install 
php artisan migrate --seed
php artisan passport:install
```

## .env
Ensure to change :
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=infojovs
DB_USERNAME=username
DB_PASSWORD=password
```
Do you need a [Docker](https://hub.docker.com/repository/docker/josanangel/lamp_php81_xdebug31_laravel/general)?

## User credentials of seeders:

### An employee : 

```
email: employee@gmail.com
password: employee
```

### A recruiter : 

```
email: recruiter@gmail.com
password: recruiter
```
