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

