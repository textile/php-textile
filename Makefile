.PHONY: all build install cs csfix test unit static clean

IMAGE?=latest

all:
	$(MAKE) build
	$(MAKE) install
	$(MAKE) cs
	$(MAKE) test

build:
	docker-compose build $(IMAGE)

ifeq ($(IMAGE),latest)
		$(MAKE) clean
endif

install:
	docker-compose run $(IMAGE) composer install

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
	rm -rf vendor
	rm -f composer.lock
