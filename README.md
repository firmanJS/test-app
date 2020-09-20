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

* tennis player
1. create tenis player want to play add ball to container
2. create container for ball
3. insert ball to container 
- Available API
  * `Player`
  - `POST` `/api/v1/player` for adding new player example rahman
  - `GET` `/api/v1/player` list player
  - `GET` `/api/v1/player/:id_palyers` list player by id
  - `PUT` `/api/v1/player/add-ball` add ball to container and verify if full
  
  * `Container`
  - `POST` `/api/v1/containers` add container
  - `GET` `/api/v1/containers` list container
  - `GET` `/api/v1/containers/:id` list container by id

* kitara store
1. insert your order to basket before checkout
2. checkout your order
- Available API
  * `Orders`
  - `POST` `/api/v1/orders` add item to basket
  - `GET` `/api/v1/orders/:order_code` list item by code transaction
  - `PUT` `/api/v1/orders/:id` update item in basket
  - `DELETE` `/api/v1/orders/:id` delete item in basket
  - `POST` `/api/v1/orders/checkout/:code_histories` update status in basket to complete transaction

* puzzle
1. solution A walk to north 3 steps 
2. solution B walk to east 5 steps 
3. solution C walk to south 1 step 
  - `GET` `/api/v1/puzzle` 
