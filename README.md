# ubrrtest
ubrr test challenge

# Установка

Для установки понадобится docker, docker-compose, git

1. Установить docker, docker-compose, git
2. Клонировать репозиторий (git clone https://github.com/bblackcblackc/ubrrtest.git)
3. Инициализировать БД
  3.1. Скопировать файл initdb.sql из корня проекта в data/db
  3.2. Запустить контейнер с БД (docker-compose up mariadb)
  3.3. Подождать инициализации БД
  3.4. Запустить в контейнере импорт из sql скрипта (docker-compose exec mariadb bash; mysql -u root -p _ПАРОЛЬ-БД_
