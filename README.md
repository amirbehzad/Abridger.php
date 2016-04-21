#  Abridger.php
Abridger is a lightweight URL shortener service, written in PHP.

## Description
A URL shortener is a web service that translates long URLs into abbreviated alternatives, and works based on URL redirection.
It uses [Slim Framework](http://www.slimframework.com/) and [Hashids](http://hashids.org), which I'm pretty impressed with.

Note: This project is my solution to [Mindvalley](http://www.mindvalley.com)'s assignment for the Web Developer position. I am sharing this for educational-purposes only.

## Deploying to Heroku
```bash
$ heroku apps:create
$ git push heroku master:master
$ heroku config:set ABRIDGER=production
$ heroku apps:rename abridger
$ heroku logs
```
Make sure you have created cfg/database.production.ini with the required settings.
