.PHONY: all clean docker-build docker-images help lint lint-fix repl shell test test-static test-unit bump bump-dev process-reports

HOST_UID ?= `id -u`
HOST_GID ?= `id -g`
IMAGE ?= php_8_4
PHP = docker compose run --rm -u $(HOST_UID):$(HOST_GID) php

all: test

vendor:
	$(PHP) composer install

clean:
	$(PHP) rm -rf build vendor .phpunit.result.cache composer.lock

lint: vendor
	$(PHP) composer lint

lint-fix: vendor
	$(PHP) composer lint-fix

test: vendor
	$(PHP) composer test

test-static: vendor
	$(PHP) composer test:static

test-unit: vendor
	$(PHP) composer test:unit

repl: vendor
	$(PHP) composer repl

shell:
	$(PHP) bash

bump: vendor
	$(PHP) composer project:bump

bump-dev: vendor
	$(PHP) composer project:bump-dev

process-reports:
	$(PHP) bash -c "test -e build/logs/clover.xml && sed -i 's/\/app\///' build/logs/clover.xml"

docker-build:
	docker-compose build php

docker-images:
	@$(PHP) bash -c "cd docker/image && ls ."

help:
	@echo "Manage project"
	@echo ""
	@echo "Usage:"
	@echo "  $$ make [command] ["
	@echo "		IMAGE=<image>"
	@echo "  ]"
	@echo ""
	@echo "Commands:"
	@echo ""
	@echo "  $$ make lint"
	@echo "  Lint code style"
	@echo ""
	@echo "  $$ make lint-fix"
	@echo "  Lint and fix code style"
	@echo ""
	@echo "  $$ make test"
	@echo "  Run linter, static and unit tests"
	@echo ""
	@echo "  $$ make test-unit"
	@echo "  Run unit tests"
	@echo ""
	@echo "  $$ make test-static"
	@echo "  Run static tests"
	@echo ""
	@echo "  $$ make repl"
	@echo "  Launch read-print-eval loop"
	@echo ""
	@echo "  $$ make shell"
	@echo "  Login into the container"
	@echo ""
	@echo "  $$ make bump"
	@echo "  Bump version"
	@echo ""
	@echo "  $$ make bump-dev"
	@echo "  Bump development version"
	@echo ""
	@echo "  $$ make clean"
	@echo "  Delete installed dependencies"
	@echo ""
	@echo "  $$ make vendor"
	@echo "  Install dependencies"
	@echo ""
	@echo "  $$ make process-reports"
	@echo "  Formats test reports to use relative local file paths"
	@echo ""
	@echo "  $$ make docker-images"
	@echo "  Lists available Docker images"
	@echo ""
	@echo "  $$ make docker-build"
	@echo "  Re-builds the Docker image"
	@echo ""
	@echo "Environment variables:"
	@echo ""
	@echo "  IMAGE"
	@echo "  Docker image that is used to run the command"
	@echo ""
