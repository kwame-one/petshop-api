## Pet Shop API

---

### Software Requirements

1. Web Server (Apache or Nginx)
2. MySQL
3. Composer
4. PHP 8.2

---

### Instructions
1. Clone the repository
2. Make a copy of **.env.example** and save it as **.env in the src directory**
3. Configure the database name and password in the **.env** file
```dotenv
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=petshop_db
DB_USERNAME=your_usename_here
DB_PASSWORD=your_password_here
```

--- 

### Commands
Open a terminal in the project's **src** directory and run the commands below
```shell
1. composer install
2. composer setup
3. php artisan serve
```
---

## Using Docker

---

### Software Requirements

1. Docker

---

### Instructions
1. Clone the repository
2. Make a copy of **.env.example** in the src directory and save it as **.env in the src directory**
3. Configure the database name and password in the **.env** file
```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql_db
DB_PORT=3306
DB_DATABASE=petshop_db
DB_USERNAME=root
DB_PASSWORD=root
```
--- 

### Commands
Open a terminal in the project's root directory and run the command below
```shell
1. docker-compose --env-file src/.env up -d
2. docker-compose exec web composer setup
```
---

## API Documentation
1. Click [here](http://localhost:80/api/documentation). to view the API documentation
