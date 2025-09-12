.PHONY: install start down build composer

install:
	docker-compose build && docker-compose up -d && docker-compose run --rm php composer install
	@echo "You can now access the application at http://localhost:8000"

start:
	docker-compose up -d
	@echo "You can now access the application at http://localhost:8000"

down:
	docker-compose down

build:
	docker-compose build

composersuggest:
	docker-compose run --rm php composer $(filter-out $@,$(MAKECMDGOALS))

composer:
	docker-compose run --rm php composer $(filter-out $@,$(MAKECMDGOALS))

# This allows passing arguments to composer
%:
	@: