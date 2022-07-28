env=dev
compose=docker-compose -f docker-compose.yaml

export compose env

.PHONY: start
start: erase build up

.PHONY: stop
stop:
		$(compose) stop $(s)

.PHONY: rebuild
rebuild: start

.PHONY: erase
erase: ## stop and delete containers, clean volumes.
		$(compose) stop
		$(compose) rm -v -f

.PHONY: build
build:
		$(compose) build
		if [ env = "prod" ]; then \
			echo Building in $(env) mode; \
			$(compose) run --rm php sh -lc 'xoff;COMPOSER_MEMORY_LIMIT=-1 composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader'; \
		else \
			$(compose) run --rm php sh -lc 'xoff;COMPOSER_MEMORY_LIMIT=-1 composer install'; \
		fi

.PHONY: start-deps
start-deps:
		$(compose) run --rm start_dependencies


.PHONY: xon
xon: ## activate xdebug simlink
		$(compose) exec -T php sh -lc 'xon | true'

.PHONY: xoff
xoff:
		$(compose) exec -T php sh -lc 'xoff | true'
		make up

.PHONY: up
up:
		$(compose) up -d


.PHONY: phpunit
phpunit:
		$(compose) exec -T php sh -lc "XDEBUG_MODE=coverage ./vendor/bin/phpunit $(conf)"
