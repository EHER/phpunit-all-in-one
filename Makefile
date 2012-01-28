default:
	git submodule update --init

version36:
	cd phpunit && git checkout 3.6 && cd ..
	cd dbunit && git checkout 1.1 && cd ..
	cd php-code-coverage && git checkout 1.1 && cd ..
	cd phpunit-selenium && git checkout 1.1 && cd ..
	cd phpunit-mock-objects && git checkout 1.1.1 && cd ..
