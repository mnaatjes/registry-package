<?php

use mnaatjes\Registry\ServiceRegistry;

// Include Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create Registry
$registry = ServiceRegistry::getInstance();

var_dump($registry);
?>