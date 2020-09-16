## TEST APP
Build with laravel 5.7 + MySql

## Installation

```sh
$ git clone https://github.com/firmanJS/test-app.git
$ cd test-app
$ cp .env-sample .env
$ docker-compose up --build -d
$ docker exec -it evermos_test bash
$ php composer.phar install
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ php artisan storage:link
$ chown -R www-data:www-data *
```

import `Evermos.postman_collection.json` to your postman

## ANSWER SOLUTION

* 01
1. create tenis player want to play add ball to container
2. create container for ball
3. insert ball to container 

* 02
1. insert your order to basket before checkout
2. checkout your order
