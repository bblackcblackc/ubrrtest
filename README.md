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
- Запустить в контейнере импорт из следующего sql скрипта. ПАРОЛЬ-БД -- root пароль от базы данных, можно найти в файле конфигурации docker-compose.yml
```
docker-compose exec mariadb bash
cd /var/lib/mysql
mysql -u root -p
Enter password: ПАРОЛЬ-БД
MariaDB [none]> source ./initdb.sql
```
- Остановить контейнер mariadb и запустить все контейнеры
```
docker-compose down
docker-compose up
```
- Возможно, для некоторых систем, резолвер которых не сконфигурирован для поддержки поддоменов localhost как собственно localhost (т.е. для поддержки имен вида api0.localhost, api1.localhost, и т.д.), придется внести изменения в файл /etc/hosts, добавить следующие строки
```
api1.localhost      127.0.0.1
api2.localhost      127.0.0.1
api3.localhost      127.0.0.1
api4.localhost      127.0.0.1
api5.localhost      127.0.0.1
```
Проверить необходимость изменений можно запустив пинг на любой подддомен localhost, например
```
ping asdfg.localhost
```
Если пинг проходит успешно -- изменения не требуются.

- Теперь на хост машине по URL http://localhost:8080 должен быть доступен веб интерфейс. Там отображается статус очереди и можно сделать тестовый запрос, нажав на кнопку
- В файле http://localhost:8080/js/ad_caller.js определена функция advertCall(id,data). В id передается идентификатор рекламного материала, в data - JSON объект, который будет сохранен на сервере. В консоль функция напишет ответ от сервера -- ид сохраненной записи.
- PHP скрипт qm/queue_processor.php в контейнере php -- менеджер очереди. Для процессинга данных его необходимо запустить следующим образом
```
docker-compose exec php bash
cd /usr/share/nginx/html/qm/
php queue_processor.php
```
