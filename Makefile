.PHONY: all build install cs csfix test unit static clean testall docs

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
	docker-compose run $(IMAGE) composer test

unit:
	docker-compose run $(IMAGE) composer test:unit

static:
	docker-compose run $(IMAGE) composer test:static

clean:

ifeq ($(IMAGE),latest)
	rm -rf vendor
	rm -f composer.lock
endif

testall:
	$(MAKE) test IMAGE=latest
	$(MAKE) test IMAGE=php_7_3
	$(MAKE) test IMAGE=php_7_2

docs:
	docker-compose run phpdoc
