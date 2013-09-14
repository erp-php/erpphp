<?php

chdir(dirname(__DIR__));

include dirname(__FILE__) . '/../vendor/autoload.php';

Zend\Mvc\Application::init(include 'config/application.config.php')->run();
