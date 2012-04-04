#!/usr/bin/env php
<?php

$dirPath = __DIR__;

$paths = array(
  ini_get("include_path"),
  $dirPath . '/dbunit',
  $dirPath . '/php-file-iterator',
  $dirPath . '/php-timer',
  $dirPath . '/phpunit',
  $dirPath . '/phpunit-selenium',
  $dirPath . '/php-code-coverage',
  $dirPath . '/php-text-template',
  $dirPath . '/php-token-stream',
  $dirPath . '/phpunit-mock-objects',
);

ini_set("include_path", implode(":", $paths));

require $dirPath . "/phpunit/phpunit.php";
