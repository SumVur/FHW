<?php

require('./infrastructure/autoloader/autoloader.php');
$autoloader = new infrastructure\autoloader\autoloader();
$autoloader->init();


$test = \infrastructure\objectManager\objectManager::create('app/test/test');

var_dump($test->Get());
