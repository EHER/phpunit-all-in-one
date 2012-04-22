<?php

$root = dirname(__DIR__) . '/src';

$paths = array($root . '/php');

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

$composerLoader = __DIR__ . '/../../.composer/autoload.php';
if (file_exists($composerLoader)) {
    $loader = require_once $composerLoader;
} else {
    require_once $root . '/symfony-class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';
    $loader = new \Symfony\Component\ClassLoader\UniversalClassLoader;
    $loader->registerNamespaces(array(
        'Symfony' => array($root . '/symfony-class-loader', $root . '/symfony-finder')
    ));
    $loader->register();
}

