	
update:
	composer update

install:
	composer install

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 public src
	composer exec -v phpstan analyse -- -c phpstan.neon --ansi