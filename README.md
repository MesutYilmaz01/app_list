
## Steps for Up This Project 
First of all start docker and up it with following command.<br />
**```docker-compose up -d```** <br /><br />
Then get in app container that contain php.<br />
**```docker exec -it mylist-app bash```**<br /><br />
Install composer with following command.<br />
**```composer install```**<br /><br />
Create database<br />
**```php artisan migrate```**<br /><br />
Seed database(Optinial) <br />
**```php artisan db:seed ```**<br />

## Sample Postman Scripts

The postman scripts will get updated as the code progress.<br />

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/12018823-77f6372c-5c31-4f24-bf32-3720f9a66a42)

**Project must work after these steps at [localhost](https://localhost:90/).**

## Database Credentials

      user: user
      password: mypassword