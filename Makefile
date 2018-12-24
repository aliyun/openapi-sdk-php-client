help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  install        to install composer."
	@echo "  test           to perform unit tests."
	@echo "  coverage-show  to show the code coverage report."


install:
	composer install --dev


test:
	vendor/bin/phpunit --coverage-clover=build/coverage.clover --coverage-html=build/coverage


coverage-show:
	open build/coverage/index.html
