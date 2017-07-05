# ubrrtest
ubrr test challenge

## Установка

Для установки понадобится docker, docker-compose, git. Используется TCP порт 8080. Команды выполнять из корня проекта, если не указано иное.

- Установить docker, docker-compose, git
- Клонировать репозиторий
```
git clone https://github.com/bblackcblackc/ubrrtest.git
``` 
- Скопировать файл **initdb.sql** из корня проекта в data/db
- Запустить контейнер с БД 
```
docker-compose up mariadb
```
- Подождать инициализации БД
- Запустить в контейнере импорт из sql скрипта 
```
docker-compose exec mariadb bash
cd /var/lib/mysql
mysql -u root -p
Enter password: ПАРОЛЬ_БД
MariaDB [none]> source ./initdb.sql
```
- Запустить остальные контейнеры
```
docker-compose up
```
- Возможно, для некоторых систем, резолвер которых не сконфигурирован для поддержки поддоменов localhost как собственно localhost (т.е. для поддержки име вида api0.localhost, api1.localhost, и т.д.), придется внести изменения в файл /etc/hosts, добавить следующие строки
```
api0.localhost      127.0.0.1
api1.localhost      127.0.0.1
api2.localhost      127.0.0.1
api3.localhost      127.0.0.1
api4.localhost      127.0.0.1
api5.localhost      127.0.0.1
```
