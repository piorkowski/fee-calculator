SHELL := /bin/bash

AMOUNT ?= 11500
TERM ?= 24

build:
	docker compose -f .dev/compose.yaml build

sh:
	docker compose -f .dev/compose.yaml run --rm php sh

composer-install:
	docker compose -f .dev/compose.yaml run --rm php composer install

test:
	docker compose -f .dev/compose.yaml run --rm php composer test:all

run:
	@if [ -z "$(AMOUNT)" ] || [ -z "$(TERM)" ]; then echo "Usage: make run AMOUNT=11500 TERM=24"; exit 2; fi
	docker compose -f .dev/compose.yaml run --rm php php bin/calculate-fee $(AMOUNT) $(TERM)
