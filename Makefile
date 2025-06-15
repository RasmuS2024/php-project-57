	
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