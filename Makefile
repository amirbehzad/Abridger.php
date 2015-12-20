export ABRIDGER:= test

test: install psr_test unit_test

install:
	composer install

psr_test:
	./vendor/bin/phpcs --standard=PSR2 --colors -p ./tests/ ./src/

unit_test:
	./vendor/bin/phpunit --stop-on-failure --stop-on-error --color=auto --columns max --bootstrap ./tests/bootstrap.php ./tests/

migrate:
	php dbup.phar init
	php dbup.phar up --ini=./cfg/database.test.ini
