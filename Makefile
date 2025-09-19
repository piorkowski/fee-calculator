SHELL := /bin/bash

.PHONY: build sh test qa cs-fix phpstan rector deptrac run

build:
	docker compose build

sh:
	docker compose run --rm php sh

install:
	docker compose run --rm php composer install

test:
	docker compose run --rm php php -d zend.assertions=1 vendor/bin/phpunit . --colors=always && \
	docker compose run --rm php vendor/bin/codecept run unit --colors

qa:
	docker compose run --rm php composer qa

cs-fix:
	docker compose run --rm php composer cs-fix

phpstan:
	docker compose run --rm php composer phpstan

rector:
	docker compose run --rm php composer rector

deptrac:
	docker compose run --rm php composer deptrac

run:
	docker compose run --rm app bin/calculate-fee $$(AMOUNT) $$(TERM)
