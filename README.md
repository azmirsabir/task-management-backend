<p align="center"><a href="https://www.newroztelecom.com/" target="_blank">


## Task Management Backend
A Task Management backend powers applications by enabling task creation, assignment, tracking, and status updates.
It provides APIs for managing users, permissions, tasks.

<br>


The app deployed on https://shalawprinting.xyz:8004

Documentation URL : http://shalawprinting.xyz:8080/swagger-ui/index.html#/

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository:**


```bash
git clone https://github.com/azmirsabir/task-management-backend.git
```

2. **Install dependencies:**

```bash
cd task-management-backend
composer install
```   

3. **Copy the example environment file:**

```bash
cp .env.example .env
```   
4. **Generate application key:**

```bash
php artisan key:generate
```   
5. **Configure the database:**
   *Update the .env file with your database credentials:*

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=username
DB_PASSWORD=password
```   

6. **Configure pusher:**
   *Update the .env file with your pusher credentials:*
```dotenv
BROADCAST_CONNECTION=pusher
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

PUSHER_APP_KEY=1209a8ebf65e10052833
PUSHER_APP_SECRET=1f1b9e48ed9115752eee
PUSHER_APP_ID=1818843
PUSHER_APP_CLUSTER=ap2
```

7. **Import Postman:**
   import Postman collection that located on `setup_files`directory at the
   root of the project folder


8. **Run database migrations and seeders:**

```bash
php artisan migrate --seed
```   

9. **Start the development server:**

```bash
php artisan serve
```

10. **Start the queue:**

```bash
php artisan queue:work
```

11. **Login with default user(Product Owner) using Login API**

```dotenv
USERNAME=azmir@gmail.com
PASSWORD=1234567
```

## Registerd artisan Commands
1. **Create User Command syntax:**
```bash
php artisan make:user {name} {email} {password}
```

2. **Export tasks Command syntax:**
```bash
php artisan export:tasks filename.csv
```

3. **Import tasks Command syntax:**
```bash
php artisan import:tasks file.csv
```

4. **send alert expiry tasks Command syntax: used by a scheduler to send alert to the product owner :**
```bash
php artisan app:send-task-expiry-alert
```


## Tests

1. **Copy the example testing environment file:**

```bash
cp .env.example .env.testing 
```

2. **Configure testing database:**
   *Update the .env.testing file with testing database credentials:*

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_db
DB_USERNAME=username
DB_PASSWORD=password
```

run tests:
```bash
php artisan test    
```


## Used Packages
For production:
- [spatie/laravel-permission]
- [pusher/pusher-php-server]
- [opcodesio/log-viewer
- [maatwebsite/excel]
- [Laravel sanctum]

