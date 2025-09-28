.PHONY: build down install shell start test up

APP_NAME=app

build:
	docker-compose build

install:
	docker-compose build && docker-compose up -d
	@echo "You can now access the application at http://localhost:8000"

start:
	docker-compose up -d
	@echo "You can now access the application at http://localhost:8000"

up:
	docker-compose up -d

down:
	docker-compose down

# This is a common Makefile target for a web service
shell:
	docker-compose exec $(APP_NAME) bash

# Or for a different service, like a database
# shell-db:
#	docker-compose exec database sh

# If you need to run it on a service that isn't currently running, use 'run'
# shell-new:
#	docker-compose run --rm web sh

test:
	docker-compose exec $(APP_NAME) vendor/bin/phpunit tests --colors=always --testdox
