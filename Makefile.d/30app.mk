migration: ## Migrates DB up to latest version
	$(DOCKER_CMD) bin/console doctrine:migration:migrate

migration-generate: ## Generates a new migration
	$(DOCKER_CMD) bin/console doctrine:migration:generate
