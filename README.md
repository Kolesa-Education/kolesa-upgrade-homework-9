# Задача
Необходимо доработать сервис админки объявлений, расположенный в этом же репозитории.
Создание сервиса и его запуск описывается в статье: [https://github.com/Kolesa-Education/php-service-practice-article](https://github.com/Kolesa-Education/php-service-practice-article)

## Tребования

Для запуска требуется установка php7.4, docker, composer.

## Запуск программы

- Сначала нужно сбилдить mysql container image c помошью команды 
```make build``` или ```docker build -t my_db . ```
- Запустить контейнер 
```make run``` или ```docker run --rm -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d my_db```
- Запулить все зависимости через
``` composer install ```
- Для запуска локального сервера в директорий public
```php -S localhost:8080 ```

## Машрутизация

- `GET /` -> просто домашняя страница
- `GET /adverts` -> для получения cписка всех объявлений
- `GET /adverts/{id}` -> для просмотра объявления c идентификатором `{id}`

- `GET /adverts/new/form` -> для получения формы заполнения нового объявления
- `POST /adverts` -> опубликовать объявление

- `GET /adverts/{id}/edit` -> для получения формы редактирования существующего объявления
- `POST /adverts/{id}/edit`-> опубликовать изменения

- `POST /adverts/search?searchtag={any}`-> искать по категориям и заголовкам
