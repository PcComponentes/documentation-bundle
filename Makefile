UID=$(shell id -u)
GID=$(shell id -g)
DOCKER_PHP_SERVICE_7=php7
DOCKER_PHP_SERVICE_8=php8

start: erase cache-folders build composer-install bash

erase:
		docker-compose down -v

build:
		docker-compose build && \
		docker-compose pull

cache-folders:
		mkdir -p ~/.composer && chown ${UID}:${GID} ~/.composer

composer-install:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_8} composer install

bash:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_8} sh

logs:
		docker-compose logs -f ${DOCKER_PHP_SERVICE_8}

.PHONY: tests
tests:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_8} phpunit

cs:
	docker-compose exec -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_8} sh -c "phpcs --standard=phpcs.xml.dist"

cbf:
	docker-compose exec -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_8} sh -c "phpcbf --standard=phpcs.xml.dist"

composer-install-7:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_7} composer install

tests-7:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE_7} phpunit