DOCKER_EXEC = docker compose exec app

.PHONY: up
up:
	docker compose up -d

.PHONY: down
down:
	docker compose down

.PHONY: build
build:
	docker compose build

.PHONY: test-integration
test-integration:
	# usage: make test-integration GROUP=kiwi
	vendor/bin/codecept run integration $(if $(GROUP),--group $(GROUP))
	# adjust later to use docker
	#	$(DOCKER_EXEC) vendor/bin/codecept run integration $(if $(GROUP),--group $(GROUP))

# stub server for Job Runner (testing only)
.PHONY: stub-server
stub-server:
	php -S localhost:9999 -t tests/tests/stubs tests/tests/stubs/server.php

# Run Symfony console inside container
.PHONY: console
console:
	$(DOCKER_EXEC) php bin/console $(COMMAND)

# Doctrine DB commands
.PHONY: doctrine-create-db
doctrine-create-db:
	$(DOCKER_EXEC) php bin/console doctrine:database:create --if-not-exists

.PHONY: doctrine-migrate
doctrine-migrate:
	$(DOCKER_EXEC) php bin/console doctrine:migrations:migrate --no-interaction

.PHONY: doctrine-make-migration
doctrine-make-migration:
	$(DOCKER_EXEC) php bin/console make:migration

.PHONY: doctrine-sql
doctrine-sql:
	$(DOCKER_EXEC) php bin/console doctrine:query:sql "$(SQL)"