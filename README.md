## Pet Shop API

---

### Software Requirements

1. Docker

---

### Instructions
1. Clone the repository
2. Make a copy of **.env.example** in the src directory and save it as **.env in the src directory**
3. Configure the database name and password in the **.env** file as below (Note use the exact same values as below)
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
2. docker-compose exec web composer install
3. docker-compose exec web composer setup
```
---

## API Documentation
1. Click [here](http://localhost:8000/api/documentation) to view the API documentation

---

## Sample credentials
1. Admin credential: ***admin@mail.com***, ***password***
2. All non admin seeder have a password called ***password***

