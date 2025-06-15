PORT ?= 8000

update:
	composer update

install:
	composer install

validate:
	composer validate

lint:
	composer exec -v phpcs .
	composer exec -v phpstan analyse -- -c phpstan.neon --ansi

test:
	php artisan test --coverage-clover reports/coverage.xml

start:
	PHP_CLI_SERVER_WORKERS=5 php -S 0.0.0.0:$(PORT) -t public