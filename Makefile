help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  install            to install composer."
	@echo "  test               to perform all tests."
	@echo "  test-unit          to perform unit tests."
	@echo "  test-feature       to perform feature tests."
	@echo "  coverage-show      to show the code coverage report."
	@echo "  cs                 to make code keep style."
	@echo "  update-endpoints   to update endpoints as array config from OSS."

install:
	composer install --dev

test:
	vendor/bin/phpunit

test-unit:
	vendor/bin/phpunit --testsuite=Unit

test-feature:
	vendor/bin/phpunit --testsuite=Feature

coverage-show:
	open coverage/coverage/index.html

cs:
	vendor/bin/php-cs-fixer fix ./

update-endpoints:
	php build/update-endpoints.php
	make cs