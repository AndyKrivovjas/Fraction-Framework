<?php

use Fraction\Application;
use Fraction\Fraction\Config\Config;

// Auto-loading core modules
require_once 'engine/Application.php';
Application::autoload();

// Defining constants
Application::defineConstants();

$config = new Config();

// Bootstrapping the application
$app = Application::bootstrap($config);