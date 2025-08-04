# AI assistant instructions

This document provides essential information for developers and AI agents interacting with this project.

## Commands

This project uses a `justfile` for command automation. The following commands are available:

*   `just init`: Initializes the project, including setting up the database.
*   `just start`: Starts the Docker containers.
*   `just stop`: Stops the Docker containers.
*   `just clean`: Removes Docker containers and cleans the Git repository.
*   `just rebuild`: Rebuilds the Docker containers and re-initializes the project.
*   `just reset-db`: Drops and recreates the database and its schema.
*   `just install`: Installs Composer dependencies.
*   `just compose [...]`: Executes `docker-compose` commands.
*   `just compose-run [...]`: Executes `docker-compose run` commands.
*   `just php [...]`: Executes PHP commands within the `php-fpm` container.
*   `just composer [...]`: Executes Composer commands.
*   `just composer-outdated`: Checks for outdated Composer dependencies.
*   `just console [...]`: Executes Symfony console commands.

## Architecture Overview

This project is a Symfony skeleton application. It follows a standard Symfony project structure:

*   **`bin/`**: Contains executable files, including the Symfony console.
*   **`config/`**: Contains application configuration, including routes, services, and packages.
*   **`docker/`**: Contains Docker-related files, including `compose.yml` and Dockerfiles for Nginx and PHP.
*   **`migrations/`**: Contains database migrations.
*   **`public/`**: Contains the front controller (`index.php`).
*   **`src/`**: Contains the application's source code, including the `Kernel.php`.
*   **`templates/`**: Contains Twig templates.
*   **`tests/`**: Contains application tests.
*   **`translations/`**: Contains translation files.

The application is containerized using Docker and uses Nginx as the web server and PHP-FPM to execute the Symfony application. It uses Doctrine for database management and Twig for templating.

## Development Notes

*   The project uses a `justfile` to simplify common development tasks.
*   The application is designed to be run in a Docker environment.
*   The database is managed using Doctrine Migrations.
*   The project follows the standard Symfony directory structure.

## General AI Agent Instructions

*   Use the `just` commands for all project-related tasks.
*   When modifying code, follow existing conventions and patterns.
*   Ensure that any new code is covered by tests.
*   Do not commit directly to the main branch. Create a new branch for each feature or bug fix.
*   Before submitting a pull request, ensure that all tests pass and the code is properly formatted.
* If you write any code mention yourself within the commit in the format: "Co-developed-by: {Provider} {Model} " Example: "Co-developed-by: Claude claude-4-sonnet"
* After making any PHP changes run just test-code-quality to make sure the code follows our quality guidelines
* Only focus on the task given, do not start refactoring stuff on your own
* Be honest, if I make a mistake tell me