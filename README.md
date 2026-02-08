> [!IMPORTANT]
> The work on this project is continued at: https://codeberg.org/m1rm/just-another-symfony-skeleton

# just-another-symfony-skeleton
My skeleton project I use for Symfony training

# Prerequisites
- PHP
- Docker
- composer
- just
- Symfony CLI

# Setup
1. Run `just install` to install the dependencies
2. Run `just start` to start the local dev server
3. visit localhost:8080 to check that Symfony is running

# Local Sites
- /hello/{name} -> a basic SF Controller showing "Hello <name>"
- /weather -> view of some weather forecast data from Open-Meteo.
This feature is utilized to showcase a basic flow of querying an external
API and processing the response

# Features
- Symfony maker bundle for faster development
- Showcases of tests
- Showcase of external API usage utilizing [Open-Meteo's](https://open-meteo.com/) forecast api (v1)

# Todo
- unhappy-path tests for existing code
- Symfony UX & Chart.js to display the weather chart data
- useful doctrine entity, migration, fixture & test
