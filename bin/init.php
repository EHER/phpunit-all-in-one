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

    $paths[] = get_include_path();
    set_include_path(implode(PATH_SEPARATOR, $paths));

    define('PEAR_ROOT_PATH', $root);

    $composerLoaderWhenInstalled = __DIR__ . '/../autoload.php';
    $composerLoaderWhenCloned   = __DIR__ . '/../vendor/autoload.php';

    if (file_exists($composerLoaderWhenInstalled)) {
        $loader = require_once $composerLoaderWhenInstalled;
    } else if (file_exists($composerLoaderWhenCloned)) {
        $loader = require_once $composerLoaderWhenCloned;
    } else {
        echo "Can't find ComposerLoader.\n";
        echo "try:\n";
        echo "\tphp composer.phar update";
        exit();
    }
});
