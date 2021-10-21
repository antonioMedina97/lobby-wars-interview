DOCKER_COMPOSE=docker-compose -f docker-compose.yml

.PHONY: build
build:
	$(DOCKER_COMPOSE) build

.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

.PHONY: test
test:
	$(DOCKER_COMPOSE) run --rm --entrypoint='vendor/bin/phpunit tests' php-signaturit