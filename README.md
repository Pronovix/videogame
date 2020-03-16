# Docker based Drupal site with Wodby containers

## Requirements

* git
* docker

## How to use

### First time setup

1. `git clone git@github.com:Pronovix/videogame.git`
1. `cd videogame`
1. `cp .env.example .env` (modify `.env` file contents to your needs)
1. `cp web/sites/default/example.settings.local.php web/sites/default/settings.local.php` (modify `settings.local.php` file contents to your needs)
1. `docker-compose up -d`
1. `docker-compose exec php composer install`
1. `docker-compose exec php drush si -y`
1. `docker-compose ps webserver` (take note of the port number, e.g. `32782` if the result was `0.0.0.0:32782->80/tcp`)
1. Visit `localhost:1234/` in your browser and change `1234` to the number you saw after `0.0.0.0:`, e.g. `localhost:32782/`
1. Enjoy

### Every day usage

1. Navigate to your project's folder in terminal
1. Make sure containers are up, run `docker-compose up -d`
1. `docker-compose ps webserver` (take note of the port number, e.g. `32782` if the result was `0.0.0.0:32782->80/tcp`)
1. Visit `localhost:1234/` in your browser and change `1234` to the number you saw after `0.0.0.0:`, e.g. `localhost:32782/`

### Running drush commands

#### Outside the php container

1. Navigate to your project's folder in terminal
1. (optional) Make sure containers are up, run `docker-compose up -d`
1. `docker-compose exec php drush DRUSHCOMMAND`, e.g. `docker-compose exec php drush cr`

#### Inside the php container

1. Navigate to your project's folder in terminal
1. (optional) Make sure containers are up, run `docker-compose up -d`
1. `docker-compose exec php bash`
1. `drush DRUSHCOMMAND`, e.g. `drush cr`

### Running composer commands

#### Outside the php container

1. Navigate to your project's folder in terminal
1. (optional) Make sure containers are up
1. `docker-compose exec php bash`
1. `composer COMPOSERCOMMAND`, e.g. `composer install`

#### Inside the php container

1. Navigate to your project's folder in terminal
1. (optional) Make sure containers are up
1. `docker-compose exec php composer COMPOSERCOMMAND`, e.g. `docker-compose exec php composer install`

### Linters

#### PHPCS

1. `docker-compose exec php ./vendor/bin/phpcs --standard=phpcs.xml`

#### ESLint

1. (optional, only need to do once) `docker-compose exec node yarn`
1. `docker-compose exec node yarn run eslint .`

### Notes

* If the containers are restarted (e.g. after reboot or after `docker-compose restart`), the webserver port will change, make sure you have the right one with `docker-compose ps webserver`
