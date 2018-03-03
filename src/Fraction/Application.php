<?php
/**
 * Created by andy.
 * Date: 2/12/18
 * Time: 4:14 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction;


use Fraction\Core\ApplicationConstantsTrait;
use Fraction\Config\Config;

class Application {
  use ApplicationConstantsTrait;

  public static $config;

  private function __construct(Config $config) {
    self::$config = $config;

    $this->init();
    $this->dispatch();
  }

  public static function bootstrap() {
    $appConfig = new Config();
    $app = new Application($appConfig);

    return $app;
  }

  public static function autoload() {
    spl_autoload_register(function ($class_name) {
      $class_name = str_replace('\\', '/', $class_name);
      $class_name = str_replace('Fraction/', '', $class_name);
      $file_path = __DIR__ . '/' . $class_name . '.php';
      include_once $file_path;
    });
  }

  private function init() {
    // Set error handling
    error_reporting(E_ALL);
    set_error_handler('Fraction\Debug\Error::errorHandler');
    set_exception_handler('Fraction\Debug\Error::exceptionHandler');

  }


  private function dispatch() {


  }
}