# InfoJovs (v of Vue) || Backend Side 
 
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
