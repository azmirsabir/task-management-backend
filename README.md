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

6. **To use *Mail-trap* for email notifications:**
   *Update the .env file with your mail-trap credentials:*
```dotenv
MAIL_USERNAME=4cf9f54cd898ba
MAIL_PASSWORD=ad11803b2ea0be
```

7. **Import Postman & SQL file:**
   import Postman collection, ostman environments and SQL file which are located under `setup_files`directory at the
   root of the
   directory:

```
├── hr_management_api
│   └── app
│   └── setup_files
│       ├── HR Management System.postman_collection.json
│       ├── local.postman_environment.json
│       ├── dev.postman_environment.json
│       ├── hr_management_api.sql
```

OR

 **Run database migrations and seeders:**

```bash
php artisan migrate --seed
```   

8. **Start the development server:**

```bash
php artisan serve
```   

9. **Access the API:**
   Local and development environments in Postman have been configured
   at http://localhost:8000 and https://hr-management-api.fly.dev respectively to interact with APIs.
    

10. **Login with default user**

```dotenv
USERNAME=nawas.abdulrahman@tornet.co
PASSWORD=password
```

## Tests

1. **Copy the example testing environment file:**

```bash
cp .env.testing.example .env.testing 
```

2. **Configure testing database:**
   *Update the .env.testing file with testing database credentials:*

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_database_name
DB_USERNAME=test_database_username
DB_PASSWORD=test_database_password
```

run tests:
```bash
php artisan test    
```
    
or run it in parallel:
```bash
php artisan test --parallel
```


## Used Packages
For development:
- [Pint](https://laravel.com/docs/11.x/pint)
- [Paratest](https://github.com/paratestphp/paratest)

For production:
- [Laravel excel](https://docs.laravel-excel.com/3.1/getting-started/)
- [Laravel sanctum](https://laravel.com/docs/11.x/sanctum)


## CI/CD

Continuous Integration and Continuous Deployment (CI/CD) are implemented for this application.
Any changes pushed to the main branch will trigger an automatic deployment,
ensuring that the latest version of the application is deployed instantly.
