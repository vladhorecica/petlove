.PHONY: help
help: ## Show Help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: unit-tests
unit-tests: ## Run unit tests
	vendor/bin/phpunit

.PHONY: migrate-db
migrate-db: ## Migrate database changes
	bin/console petlove:MigrateDb

.PHONY: install
install: ## Install composer dependencies
	composer install
