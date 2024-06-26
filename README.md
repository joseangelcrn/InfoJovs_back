<img src="https://github.com/joseangelcrn/InfoJovs_front/assets/47973568/d791fb03-8a2c-4dcf-af0d-00152e932339" width="100" height="100"> 


# InfoJovs (v of Vue) || Backend Side of [InfoJovs_front](https://github.com/joseangelcrn/InfoJovs_front)


|         | Version    |
| :---:   | :---: | 
| PHP     | 8.1   |
| Laravel     | 10   |

## An infojobs app based (in progress..)

<hr>

An application with two main roles ( **Recruiter** and **Employee** )  where you can **offer jobs** if you are  Recruiter or **to apply for jobs** if are an Employee.


### **Recruiter**

- [x] You can create offers
- [x] You can close your offers 
- [x] See how many employees have applied to the offer
- [x] Change status of candidatures for employees who has applied in your own offers
- [x] You can attach questions to job application. It will be displayed to employees once they will applicate job.


### **Employee**

- [x] You can apply offers
- [x] See your candidatures status
- [x] You can see an history of  your candidatures.
- [ ] You can create a dynamic CV who recruiters will be able to see to get more information of  your professional profile
- [ ] You can search jobs filtering by different fields

### **Infrastructure**

- [ ] Queue Service to manage notifications when Recruiters changes candidatures statuses of Employees. (RabbitMQ, Kafka... )

### **Others**

- [ ] Improve filters of Job Finder

      
<hr>

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

### Docker Setup  (Recommended)

Do you need a [Docker](https://hub.docker.com/repository/docker/josanangel/lamp_php81_xdebug31_laravel/general)?

Remember to change in your `.env`:

````
DB_CONNECTION=host.docker.internal
````

Pull Image:

````
docker pull josanangel/lamp_php81_xdebug31_laravel
````

Create your **InfoJovs_back container**: 

````
docker  run -d --name infojovs_back  -p 8686:80 -v "/path/to/InfoJovs_back:/var/www/html/app" josanangel/lamp_php81_xdebug31_laravel
````

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

