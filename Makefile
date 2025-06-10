	
update:
	composer update

install:
	composer install

validate:
	composer validate

lint:
	composer exec phpcs
	composer exec -v phpstan analyse -- -c phpstan.neon --ansi