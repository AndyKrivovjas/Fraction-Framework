<?php

use Fraction\Application;

// Auto-loading core modules
require_once 'engine/Core/ApplicationConstantsTrait.php';
require_once 'engine/Application.php';
Application::autoload();

// Defining constants
Application::defineConstants();

// Bootstrapping the application
$app = Application::bootstrap();