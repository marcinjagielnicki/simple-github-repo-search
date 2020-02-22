#!make

ifndef DOCKER_MAIN_PATH
	DOCKER_MAIN_PATH=$(CURDIR)
endif

COMPOSER_CMD=composer
GO_TO_DOCKER_DIRECTORY=cd $(DOCKER_MAIN_PATH) &&
DOCKER_BASH=$(GO_TO_DOCKER_DIRECTORY) docker-compose exec php-fpm
NODE_BASH=$(GO_TO_DOCKER_DIRECTORY) docker-compose exec node
DUMP_FILE=$(PROJECT)/$(DUMP_DIRECTORY_PATH)/$(DUMP_FILENAME)

BUILD_PRINT = @echo "\033[0;32m [\#] \033[0m \033[0;33m \033[0m"

.DEFAULT_GOAL := help

help:                                                                           ## shows this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\.]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

#SILENT=> /dev/null 2>&1
SILENT=

#================================================
# MAIN
#================================================
start: start-docker composer-install clean-cache ## run application
	${BUILD_PRINT} DONE

stop: ## Stop docker services
	$(GO_TO_DOCKER_DIRECTORY) docker-compose stop

restart: rm start ##remove containers and run

rm: ## Remove all docker services
	${BUILD_PRINT} REMOVING ALL SERVICES
	$(GO_TO_DOCKER_DIRECTORY) docker-compose down -v $(SILENT)
start-docker: ## start docker containers
	$(GO_TO_DOCKER_DIRECTORY) docker-compose up -d $(SILENT)

install: composer-install ## install aplication: composer

apply-code-updates: composer-install


warmup-project: start copy-env install  rm-cache  ## install project from scratch
warmup-project-with-data: start install rm-cache  ## install project from scratch with test data

#================================================
# SETTINGS
#================================================
bash: ## run docker bash
	$(GO_TO_DOCKER_DIRECTORY) docker-compose exec php-fpm bash

#================================================
# APPLICATION MANAGEMENT
#================================================

phpunit: ## run unit tests
	${DOCKER_BASH} bin/phpunit

coverage: ## run phpunit with coverage generation
	${DOCKER_BASH} bin/phpunit --coverage-html=coverage

composer-install:  ## run composer install
	$(DOCKER_BASH) $(COMPOSER_CMD) install --no-interaction --optimize-autoloader

clear-cache:  ##clear cache
	$(DOCKER_BASH) bin/console ca:cl

rm-cache: ## rm var/cache/*
	$(DOCKER_BASH) rm -rf var/cache/*

clean-cache: ## clean cache warmup prod+dev
	${BUILD_PRINT} REMOVING CACHE
	-$(DOCKER_BASH) bin/console cache:warmup -e prod $(SILENT)
	-$(DOCKER_BASH) bin/console cache:warmup -e dev $(SILENT)

copy-env: ## copy .env.dist to .env
	$(DOCKER_BASH) cp .env .env.local



#================================================
# FRONTEND
#================================================

front-install:
	$(NODE_BASH) yarn install

front-build:
	$(NODE_BASH) yarn run dev

