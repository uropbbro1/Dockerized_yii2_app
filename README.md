# Dockerized_yii2_app
Докеризированное yii2 приложение
Инструкция по запуску:
1. клонировать репозиторий в пустую папку с проектом (git clone https://github.com/uropbbro1/Dockerized_yii2_app.git)
2. перейдите в папку проекта (cd Dockerized_laravel_app)
3. Запустите Docker Desktop
4. поднимите контейнеры приложения (docker-compose up --build -d)
5. зайдите в контейнер php (docker-compose exec -it php sh)
6. зайти в папку проекта (cd ..) (cd app)
7. установить зависимости с помощью сервиса composer (composer install)
8. перейти по адресу http://localhost:8000
После этого уже можно работать с приложением
