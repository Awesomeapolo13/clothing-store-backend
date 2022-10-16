# Магазин одежды backend #

## Описание ##

Backend API онлайн магазина одежды

## Установка проекта локально ##

Запустить команду в корне проекта для сборки образов:

```bash
docker-compose -f ./deployment/docker/docker-compose.yml --env-file ./deployment/docker/.env build
```

Затем запустить проект:

```bash
docker-compose -f ./deployment/docker/docker-compose.yml --env-file ./deployment/docker/.env up
```
