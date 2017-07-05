# ubrrtest
ubrr test challenge

## Установка

Для установки понадобится docker, docker-compose, git
Используется TCP порт 8080

1. Установить docker, docker-compose, git
1. Клонировать репозиторий (git clone [https://github.com/bblackcblackc/ubrrtest.git](https://github.com/bblackcblackc/ubrrtest.git))
1. Скопировать файл initdb.sql из корня проекта в data/db
1. Запустить контейнер с БД (docker-compose up mariadb)
1. Подождать инициализации БД
1. Запустить в контейнере импорт из sql скрипта (docker-compose exec mariadb bash; mysql -u root -p _ПАРОЛЬ-БД_
1. Запустить остальные контейнеры
