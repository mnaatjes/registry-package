<?php

use mnaatjes\Registry\ServiceRegistry;

// Include Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create Registry
$registry = ServiceRegistry::getInstance();

$registry->register("path.to.file", "Here is a string", ["string"]);
?>