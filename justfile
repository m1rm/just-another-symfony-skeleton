export UID := `id -u`
export GID := `id -g`

COMPOSE := 'docker compose -f docker/compose.yml'
COMPOSE-RUN := COMPOSE + ' run --rm'
PHP-DB-RUN := COMPOSE-RUN + ' php-fpm'
PHP-RUN := COMPOSE-RUN + ' --no-deps php-fpm'
DB-RUN := COMPOSE-RUN + ' --no-deps db'

default:
	just --list

# lifecycle commands
init: start
	{{PHP-DB-RUN}} bin/console cache:warmup
	{{PHP-DB-RUN}} bin/console doctrine:database:drop --force --if-exists
	{{PHP-DB-RUN}} bin/console doctrine:database:create
	{{PHP-DB-RUN}} bin/console doctrine:schema:create
	{{PHP-DB-RUN}} bin/console doctrine:migrations:sync-metadata-storage --no-interaction
	{{PHP-DB-RUN}} bin/console doctrine:migrations:version --add --all --no-interaction

start:
	{{COMPOSE}} up -d
	{{DB-RUN}} mysqladmin -uroot -pChangeMe -hdb --wait=10 ping
	@echo URL: http://localhost:8080

stop:
	{{COMPOSE}} stop

clean:
	{{COMPOSE}} rm -vsf
	git clean -fdqx -e .idea


rebuild: clean
	{{COMPOSE}} build --pull
	just install
	just init

reset-db:
    {{PHP-DB-RUN}} bin/console doctrine:database:drop --force --if-exists
    {{PHP-DB-RUN}} bin/console doctrine:database:create
    {{PHP-DB-RUN}} bin/console doctrine:schema:create

install:
	{{PHP-RUN}} composer --no-interaction install

# utility commands
compose *args:
	{{COMPOSE}} {{args}}

compose-run *args:
	{{COMPOSE-RUN}} {{args}}

php *args='-h':
	{{PHP-RUN}} php {{args}}

composer *args:
	{{PHP-RUN}} composer {{args}}

composer-outdated: (composer "install") (composer "outdated --direct --strict")

console *args:
	{{PHP-RUN}} bin/console {{args}}