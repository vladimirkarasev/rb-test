# Тестовое задание для ООО РБ

Ссылка на [тестовое задание](https://docs.google.com/document/d/10f6Sp7Rh9nGPl7AW1lHGKWq-bgpSsbOeYjkdUPHlcyA/edit)

### Развертка проекта
В файле [docker-compose.override.yml](docker-compose.override.yml) понять id пользователя и id группы на ваш. Узнать можно 
```shell
echo "${UID}:${GID}"
```
В файле [/docker_configs/php7.4/Dockerfile](docker_configs%2Fphp7.4%2FDockerfile) поменять id пользователя в строке 14 на ваш.

### Запустить проект 
```shell
docker compose up -d
```

### Собрать проект 
```shell
docker compose up -d --build
```

### Установка зависимостей composer
```shell
docker compose exec -it php74-service composer install
``` 