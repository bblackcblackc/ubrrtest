# ubrrtest
ubrr test challenge

## Установка

Для установки понадобится docker, docker-compose, git
Используется TCP порт 8080

- Установить docker, docker-compose, git
- Клонировать репозиторий
```
git clone [https://github.com/bblackcblackc/ubrrtest.git](https://github.com/bblackcblackc/ubrrtest.git)
``` 
- Скопировать файл initdb.sql из корня проекта в data/db
- Запустить контейнер с БД 
```
docker-compose up mariadb
```
- Подождать инициализации БД
- Запустить в контейнере импорт из sql скрипта 
```
docker-compose exec mariadb bash
mysql -u root -p _ПАРОЛЬ-БД_
```
- Запустить остальные контейнеры
