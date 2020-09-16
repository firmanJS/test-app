## TEST APP
Build with laravel 5.7 + MySql

## Installation

```sh
$ git clone https://github.com/firmanJS/test-app.git
$ cd test-app
$ cp .env.example .env
$ docker-compose up --build -d
$ docker exec -it evermos_test bash
$ php composer.phar install
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ php artisan storage:link
$ chown -R www-data:www-data *
```