<?php

require('./infrastructure/autoloader/StaticAutoloader.php');
\infrastructure\autoloader\StaticAutoloader::initialize();


$test = \infrastructure\objectManager::create('app/test/test');
var_dump($test->Get());
