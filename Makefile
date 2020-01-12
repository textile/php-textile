.PHONY: all build install cs csfix test unit static clean testall docs help

IMAGE?=latest

all:
	$(MAKE) clean
	$(MAKE) build
	$(MAKE) install
	$(MAKE) cs
	$(MAKE) test

build:
	docker-compose build $(IMAGE)

install:

ifeq ($(IMAGE),latest)
	docker-compose run $(IMAGE) composer install
endif

update:
	docker-compose run $(IMAGE) composer update

cs:
	docker-compose run $(IMAGE) composer cs

csfix:
	docker-compose run $(IMAGE) composer csfix

test:
	@docker-compose run $(IMAGE) bash -c 'test -e vendor || composer install'
	docker-compose run $(IMAGE) composer test

unit:
	@docker-compose run $(IMAGE) bash -c 'test -e vendor || composer install'
	docker-compose run $(IMAGE) composer test:unit

static:
	@docker-compose run $(IMAGE) bash -c 'test -e vendor || composer install'
	docker-compose run $(IMAGE) composer test:static

clean:

ifeq ($(IMAGE),latest)
	docker-compose run $(IMAGE) rm -rf vendor composer.lock
endif

testall:
	$(MAKE) test IMAGE=latest
	$(MAKE) test IMAGE=php_7_3
	$(MAKE) test IMAGE=php_7_2

docs:
	docker-compose run phpdoc --template markdown

help:
	@echo "Run PHP-Textile test suite"
	@echo ""
	@echo "Usage:"
	@echo "  make [command] [IMAGE=<image>]"
	@echo ""
	@echo "Commands:"
	@echo ""
	@echo "  make all      Run all"
	@echo ""
	@echo "  make build    Build image"
	@echo "  make clean    Reset Composer dependencies"
	@echo "  make install  Install Composer dependencies"
	@echo "  make update   Update Composer dependencies"
	@echo ""
	@echo "  make cs       Check code style"
	@echo "  make csfix    Try to fix code style"
	@echo ""
	@echo "  make test     Run static and unit tests"
	@echo "  make unit     Run only unit tests"
	@echo "  make static   Run only static tests"
	@echo ""
	@echo "  make testall  Run tests against each image"
	@echo ""
	@echo "  make docs     Generate API documentation"
	@echo ""
	@echo "Images:"
	@echo ""
	@echo "  latest"
	@echo "  php_7_2"
	@echo "  php_7_3"
