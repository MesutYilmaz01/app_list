
## Steps for Up This Project 
First of all start docker and up it with following command.<br />
**```docker-compose up -d```** <br /><br />
Then get in app container that contain php.<br />
**```docker exec -it mylist-app bash```**<br /><br />
Install composer with following command.<br />
**```composer install```**<br /><br />
Create database<br />
**```php artisan migrate```**<br />
Seed database(Optinial) <br />
**```php artisan db:seed ```**<br />

**Project must work after these steps at [localhost](https://localhost:90/).**

## Database Credentials

      user: user
      password: mypassword