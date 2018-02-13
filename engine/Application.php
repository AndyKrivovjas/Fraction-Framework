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


use Fraction\Fraction\Config\Config;

class Application {
  public function __construct(Config $config) {
    $this->init($config->getAll());
    $this->dispatch();

  }

  public static function bootstrap(Config $config) {
    $app = new Application($config);

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

  public static function defineConstants() {
    define('DIR_ENGINE', __DIR__);
    define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
    define('DIR_APP', DIR_ROOT . '/app');
    define('DIR_CONFIG', DIR_ROOT . '/config');
    define('DIR_LOGS', DIR_ROOT . '/var/logs');
    define('DIR_CACHE', DIR_ROOT . '/var/cache');
  }


  private function init($config) {

    // Set error handling
    error_reporting(E_ALL);
    set_error_handler('Fraction\Debug\Error::errorHandler');
    set_exception_handler('Fraction\Debug\Error::exceptionHandler');

  }


  private function dispatch() {


  }
}