export UID := `id -u`
export GID := `id -g`

COMPOSE := 'docker compose -f docker/compose.yml'
COMPOSE-RUN := COMPOSE + ' run --rm'
PHP-DB-RUN := COMPOSE-RUN + ' php-fpm'
PHP-RUN := COMPOSE-RUN + ' --no-deps php-fpm'
DB-RUN := COMPOSE-RUN + ' --no-deps db'

default:
	just --list

## lifecycle commands

# freshly init the project including db reset
init: start
	{{PHP-DB-RUN}} bin/console cache:warmup
	{{PHP-DB-RUN}} bin/console doctrine:database:drop --force --if-exists
	{{PHP-DB-RUN}} bin/console doctrine:database:create
	{{PHP-DB-RUN}} bin/console doctrine:schema:create
	{{PHP-DB-RUN}} bin/console doctrine:migrations:sync-metadata-storage --no-interaction
	{{PHP-DB-RUN}} bin/console doctrine:migrations:version --add --all --no-interaction

# start services as defined in docker/compose.yml
start:
	{{COMPOSE}} up -d
	@echo URL: http://localhost:8080

# stop all services
stop:
	{{COMPOSE}} stop

# cleanup containers and unversioned changes
clean:
	{{COMPOSE}} rm -vsf
	git clean -fdqx -e .idea

# cleanup and rebuild containers including dependency installation and db reset
rebuild: clean
	{{COMPOSE}} build --pull
	just install
	just init

# drop existing db and recreate it with doctrine:database:create and doctrine:schema:create
reset-db:
    {{PHP-DB-RUN}} bin/console doctrine:database:drop --force --if-exists
    {{PHP-DB-RUN}} bin/console doctrine:database:create
    {{PHP-DB-RUN}} bin/console doctrine:schema:create

# install dependencies defined in composer.lock
install:
	{{PHP-RUN}} composer --no-interaction install

## utility commands

# alias for: docker compose -f docker/compose.yml
compose *args:
	{{COMPOSE}} {{args}}

# alias for: docker compose -f docker/compose.yml run --rm
compose-run *args:
	{{COMPOSE-RUN}} {{args}}

# run php inside the phpfpm container
php *args='-h':
	{{PHP-RUN}} php {{args}}

# run composer inside the phpfpm container
composer *args:
	{{PHP-RUN}} composer {{args}}

[private]
composer-outdated: (composer "install") (composer "outdated --direct --strict")

# direct access to bin/console inside the phpfpm container
console *args:
	{{PHP-RUN}} bin/console {{args}}

## commands mainly used in ci
[private]
test-security: (composer "audit")

[private]
outdated: (composer "install") (composer "outdated --direct --strict")

