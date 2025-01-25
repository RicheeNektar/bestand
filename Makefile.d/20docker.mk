start: ## Starts docker containers
	docker compose up -d

stop: ## Stops docker containers
	docker compose down --remove-orphans
