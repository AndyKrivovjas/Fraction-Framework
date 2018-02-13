<?php

use Fraction\Application;
use Fraction\Fraction\Config\Config;

// Auto-loading core modules
require_once 'engine/Application.php';
Application::autoload();

// Defining constants
Application::defineConstants();

$appConfig = new Config();

// Bootstrapping the application
$app = Application::bootstrap($appConfig);

echo $s['1'];