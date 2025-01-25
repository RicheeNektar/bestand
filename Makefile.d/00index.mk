.DEFAULT_GOAL: help
.PHONY: all
.SILENT:

UID = $(id -u)
GID = $(id -g)

DOCKER_CMD = docker compose exec -u $(UID):$(GID) php