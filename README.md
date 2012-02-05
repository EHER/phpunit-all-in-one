# PHPUnit All in One

That's another way to install PHPUnit without the PEAR

## Git 

Just clone and run

	./phpunit.php

or

	/path/to/phpunit-all-in-one/phpunit.php


## Composer

Add ["EHER/PHPUnit"](http://packagist.org/packages/EHER/PHPUnit) package to your composer.json file

    {
        "require": {
            "php":          ">=5.3.2",
            "EHER/PHPUnit": ">=1.2"
        }
    }

After install/update vendors with Composer, you can simply run

    php vendor/EHER/PHPUnit/phpunit.php

