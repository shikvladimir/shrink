include .env
ifeq ($(APP_ENV), local)
    DOCKER_COMPOSE = docker-compose.yml
else
    DOCKER_COMPOSE = docker-compose.prod.yml
endif

init: docker-down-clear docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: down up
app: container-app
node: container-node
logs: docker-logs
ps: docker-ps

docker-pull:
	docker compose -f $(DOCKER_COMPOSE) pull

docker-build:
	docker compose -f $(DOCKER_COMPOSE) build --pull

docker-down-clear:
	docker compose -f $(DOCKER_COMPOSE) down -v --remove-orphans

docker-up:
	docker compose -f $(DOCKER_COMPOSE) up -d

docker-down:
	docker compose -f $(DOCKER_COMPOSE) down --remove-orphans

container-app:
	docker exec -it app_${APP_NAME} bash

container-node:
	docker exec -it node_${APP_NAME} bash

docker-logs:
	docker compose logs -t

docker-ps:
	docker compose ps
