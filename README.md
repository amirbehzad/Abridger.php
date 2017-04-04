#  Abridger.php
Abridger is a lightweight URL shortener service, written in PHP.

## Description
A [URL shortener](https://en.wikipedia.org/wiki/URL_shortening) is a web service that provides abbreviated alternatives for long URLs. It works based on URL redirection.
My implementation uses [Slim Framework](http://www.slimframework.com/), and [Hashids](http://hashids.org). I'm pretty impressed with both of these frameworks because of their simplicity. The database migration is handled by [dbup](https://github.com/brtriver/dbup).

## Installation, and Local Testing
```bash
$ git clone https://github.com/amirbehzad/Abridger.php.git
$ cd Abridger.php/
$ make install
$ make migrate
$ make test
$ ABRIDGER=test php -S localhost:8000 -t wwwroot/
```
Note: The *make migrate* command depends on [dbup](https://github.com/brtriver/dbup), and requires an existing MySQL database, named as *test_abridger*.

## Deployment on Heroku
```bash
$ heroku apps:create
$ git push heroku master:master
$ heroku config:set ABRIDGER=production
$ heroku apps:rename abridger
$ heroku logs
```
Make sure you have created cfg/database.production.ini with the required settings.
