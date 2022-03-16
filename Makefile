container-php = ts-php
placeholder:
	@echo "------------------------------------------------------------------"
	@echo "| COMMAND            | DESCRIPTION                               |"
	@echo "------------------------------------------------------------------"
	@echo "| install            | Up from the ground                        |"
	@echo "| start              | Up docker containers                      |"
	@echo "| stop               | Down docker containers                    |"
	@echo "| restart            | Restart docker containers                 |"
	@echo "| ------------------ | ----------------------------------------- |"
	@echo "| cache              | Clear cache                               |"
	@echo "| ------------------ | ----------------------------------------- |"
	@echo "| composer           | Run composer from PHP container           |"
	@echo "| console            | Run console from PHP container            |"
	@echo "| ------------------ | ----------------------------------------- |"
	@echo "| tests              | Run phpunit tests                         |"
	@echo "| deptrac            | Run deptrac                               |"
	@echo "| psalm              | Run psalm                                 |"
	@echo "| phpcs              | Run phpcs                                 |"
	@echo "| phpstan            | Run phpstan                               |"
	@echo "| ------------------ | ----------------------------------------- |"
	@echo "| pre-commit         | Run all analizators before make commit    |"

install:
	docker network create ts
	cd ./docker && docker-compose up -d
	docker exec -it $(container-php) bash -c "composer install"

start:
	cd ./docker && docker-compose up -d

stop:
	cd ./docker && docker-compose down

restart: stop start

migrate:
	docker exec -it $(container-php) bash -c "php bin/console --no-interaction doctrine\:migrations\:migrate"

cache:
	docker exec -it $(container-php) bash -c "php bin/console doctrine:cache:clear-metadata"
	docker exec -it $(container-php) bash -c "php bin/console cache:clear"
	@echo "Cache is clean"

tests:
	docker exec -it $(container-php) bash -c "vendor/bin/phpunit -c src/Components/TournamentSimulation/config/phpunit.xml"
	@echo "Tests done!"

deptrac:
	docker exec -it $(container-php) bash -c "vendor/bin/deptrac analyze deptrac.yaml --no-cache"
	docker exec -it $(container-php) bash -c "vendor/bin/deptrac analyze src/Components/DeliveryTariff/config/deptrac.yaml --no-cache"
	@echo "deptrac done!"

psalm:
	docker exec -it $(container-php) bash -c "vendor/bin/psalm -c src/Components/TournamentSimulation/config/psalm.xml"
	@echo "psalm done!"

phpcs:
	docker exec -it $(container-php) bash -c "PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --dry-run --diff --config=src/Components/TournamentSimulation/config/.php-cs-fixer.php"
	@echo "phpcs done"

phpstan:
	docker exec -it $(container-php) bash -c "vendor/bin/phpstan analyse src/Components/TournamentSimulation -c src/Components/TournamentSimulation/config/phpstan.neon"
	@echo "ecs done"

composer:
	docker exec -it $(container-php) bash -c "composer $(filter-out $@,$(MAKECMDGOALS))"

composer-dev:
	docker exec -it $(container-php) bash -c "composer $(filter-out $@,$(MAKECMDGOALS)) --dev"

console:
	docker exec -it $(container-php) bash -c "php bin/console $(filter-out $@,$(MAKECMDGOALS))"

pre-commit: phpcs psalm phpstan deptrac tests
	@: