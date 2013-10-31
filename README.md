# PHPUnit All in One

That's another way to install PHPUnit without the PEAR

## Git 

Just clone and run

	./bin/phpunit

or

	/path/to/phpunit-all-in-one/bin/phpunit


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



[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/EHER/phpunit-all-in-one/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

