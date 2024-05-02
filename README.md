<img src="https://github.com/joseangelcrn/InfoJovs_front/assets/47973568/d791fb03-8a2c-4dcf-af0d-00152e932339" width="100" height="100"> 


# InfoJovs (v of Vue) || Backend Side of [InfoJovs_front](https://github.com/joseangelcrn/InfoJovs_front)


|         | Version    |
| :---:   | :---: | 
| PHP     | 8.1   |
| Laravel     | 10   |

## An infojobs app based (in progress..) 

## Setup 

```
cd InfoJovs_back
cp .env.example .env
composer install 
php artisan migrate --seed
php artisan passport:install
```

### .env
Ensure to change :
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=infojovs
DB_USERNAME=username
DB_PASSWORD=password
```
### Quick launch

````
php artisan serve --port 8686
````

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
