it: cs test

composer:
	composer install

coverage: composer
	cp phpspec.with-coverage.yml.dist phpspec.yml
	bin/phpspec run
	rm phpspec.yml

cs: composer
	bin/php-cs-fixer fix --config=.php_cs --verbose --diff

test: composer
	bin/phpspec run
