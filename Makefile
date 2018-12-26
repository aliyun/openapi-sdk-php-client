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
	vendor/bin/phpunit --coverage-clover=build/coverage.clover --coverage-html=build/coverage

test-unit:
	vendor/bin/phpunit --testsuite=Unit --coverage-clover=build/coverage.clover --coverage-html=build/coverage

test-feature:
	vendor/bin/phpunit --testsuite=Feature --coverage-clover=build/coverage.clover --coverage-html=build/coverage

coverage-show:
	open build/coverage/index.html

cs:
	php php-cs-fixer fix ./

update-endpoints:
	php build/update-endpoints.php
	make cs