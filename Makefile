-include .env

DKC = docker-compose
DK = docker

.PHONY: help
help: ## Show Help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: tests
tests: ## Run all test commands
	cd application && make unit-tests

dk-build: ## Build containers
	$(DKC) build

dk-up: ## Start containers
	$(DKC) up -d

dk-stop: ## Stop containers (but do not destroy them)
	$(DKC) stop

dk-prune: ## Clean containers
	$(DKC) down -v --rmi local --remove-orphans

dk-migrate-db: ## Make database up to date
	$(DK) exec -ti pet-php-fpm /bin/bash -c "bin/console petlove:MigrateDb"

dk-create-admin: ## Create admin user. arg `name` required
	$(DK) exec -ti $(CONTAINER_NAME_PREFIX)-php-fpm /bin/bash -c "bin/console petlove:CreateAdminBackendUser $(name)@admin.com $(name) $(name)"

dk-ui-start:
	$(DK) exec -ti $(CONTAINER_NAME_PREFIX)-node /bin/bash -c "make start"

dk-install:
	$(DK) exec -ti $(CONTAINER_NAME_PREFIX)-node /bin/bash -c "make install"
