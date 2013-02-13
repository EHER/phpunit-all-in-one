# PHPUnit All in One

That's another way to install PHPUnit without the PEAR

## Git 

Just clone and run

	./bin/phpunit

or

	/path/to/phpunit-all-in-one/bin/phpunit


## Composer

Add ["zerkalica/phpunit"](http://packagist.org/packages/zerkalica/phpunit) package to your composer.json file

    {
        "require": {
            "php":          ">=5.4.0",
            "zerkalica/phpunit": ">=1.2"
        }
    }

After install/update vendors with Composer, you can simply run

    php vendor/zerkalica/phpunit/bin/phpunit.php

