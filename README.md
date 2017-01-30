#  Abridger.php
Abridger is a lightweight URL shortener service, written in PHP.

## Description
A URL shortener is a web service that translates long URLs into abbreviated alternatives. It works based on URL redirection.
My implementation uses [Slim Framework](http://www.slimframework.com/), and [Hashids](http://hashids.org). I'm pretty impressed with both of these frameworks.

Note: This is not rocket-science. I am sharing this for demonstration and educational-purposes only. Use at your own risk.

## Deploying to Heroku
```bash
$ heroku apps:create
$ git push heroku master:master
$ heroku config:set ABRIDGER=production
$ heroku apps:rename abridger
$ heroku logs
```
Make sure you have created cfg/database.production.ini with the required settings.
