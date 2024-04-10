# Тестовое задание для ООО РБ

Ссылка на [тестовое задание](https://docs.google.com/document/d/10f6Sp7Rh9nGPl7AW1lHGKWq-bgpSsbOeYjkdUPHlcyA/edit)

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