<?php

call_user_func(function() {

    $root = dirname(__DIR__) . '/src';

    $paths = array();

    foreach(new DirectoryIterator($root) as $item) {
        if($item->isDot()) {
            continue;
        }
        $fileName = $root . '/' . $item->getFileName();
        $paths[] = $fileName;
    }

    define('PEAR_ROOT_PATH', $root);

    $composerLoaderWhenInstalled = __DIR__ . '/../../../autoload.php';
    $composerLoaderWhenCloned   = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($composerLoaderWhenInstalled)) {
        $loader = require_once $composerLoaderWhenInstalled;
    } else if (file_exists($composerLoaderWhenCloned)) {
        $loader = require_once $composerLoaderWhenCloned;
    } else {
        $classLoader = $root . '/symfony-class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

        //fallback mode, if no composer installed, try to use symfony components in src
        if (file_exists($classLoader)) {
            require_once $classLoader;
            $loader = new \Symfony\Component\ClassLoader\UniversalClassLoader;
            $loader->registerNamespaces(array(
                'Symfony' => array($root . '/symfony-class-loader', $root . '/symfony-finder')
            ));
            $loader->register();
        } else {
            echo "Can't find ComposerLoader.\n";
            echo "try:\n";
            echo "\tphp composer.phar update";
            exit();
        }
    }

    if ($loader) {
        $prefixes = $loader->getPrefixes();
        // some old components do not use autoloader and includes symfony components directly - add them to include path
        foreach(array('Symfony', 'Symfony\\Component\\Finder') as $key) {
            if(isset($prefixes[$key])) {
                foreach($prefixes[$key] as $path) {
                    $paths[] = $path;
                }
            }
        }
    }
    $paths[] = get_include_path();
    set_include_path(implode(PATH_SEPARATOR, $paths));
});
