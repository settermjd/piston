it: cs test

composer:
	composer install

coverage: composer
	bin/phpspec run --config phpspec.with-coverage.yml

cs: composer
	bin/php-cs-fixer fix --config=.php_cs --verbose --diff

test: composer
	bin/phpspec run --config phpspec.yml
