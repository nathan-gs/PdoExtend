<?php
error_reporting(-1);

require_once __DIR__.'/vendor/UniversalClassLoader/UniversalClassLoader.php';

$loader = new \UniversalClassLoader\UniversalClassLoader();

$loader->registerNamespaces(array(
    'PdoExtend\\Tests'   => __DIR__,
    'PdoExtend'   => __DIR__.'/../src',
));

$loader->register();