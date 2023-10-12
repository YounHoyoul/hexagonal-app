PROJECT_NAME="haxagonal-app"
DOCKER_COMPOSE=docker-compose -p $(PROJECT_NAME) -f ./docker-compose.yml
APP_CONTAINER="laravel.test"

## ----------------------
## Docker composer management
## ----------------------

.PHONY: build
build: ## Build the stack
	$(DOCKER_COMPOSE) build --no-cache

.PHONY: up
up: ## Environment up!
	$(DOCKER_COMPOSE) up -d

.PHONY: ps
ps: ## Environment up!
	$(DOCKER_COMPOSE) ps

.PHONY: restart
restart: ## Restart environment.
	$(DOCKER_COMPOSE) restart

.PHONY: bash
bash:
	$(DOCKER_COMPOSE) exec -it $(APP_CONTAINER) bash

.PHONY: down
down:
	$(DOCKER_COMPOSE) down

.PHONY: logs
logs:
	$(DOCKER_COMPOSE) logs $(APP_CONTAINER)

## ----------------------
## Laravel commands
## ----------------------

.PHONY: test
test:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash -c "php artisan test"

.PHONY: autoload
autoload:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash -c "composer dump-autoload"

.PHONY: migrate
migrate:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash -c "php artisan migrate"

.PHONY: clean
clean:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash -c "php artisan cache:clear"

.PHONY: pint
pint:
	./vendor/bin/pint