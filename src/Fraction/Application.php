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


use Fraction\Controller\SingletonTrait;
use Fraction\Core\ApplicationConstantsTrait;
use Fraction\Config\Config;
use Fraction\DependencyInjection\Container;
use Fraction\DependencyInjection\ContainerInterface;
use Fraction\Loader\Autoloader;
use Fraction\Routing\Router;
use Fraction\Yaml\Yaml;

class Application {
  use ApplicationConstantsTrait;
  use SingletonTrait;

  public static $config;
  /** @var ContainerInterface */
  private $container;
  /** @var Router */
  private $router;

  private function __construct(ContainerInterface $container) {
    self::$config = $container->get(Config::class);
    $this->container = $container;

    // Injecting router
    $routing = Yaml::parse(Application::getDirConfig() . '/components.yml');
    $this->container->bind(Router::class)->addArgs($routing);
    $this->router = $this->container->get(Router::class);

    // Setting error handling
    error_reporting(E_ALL);
    set_error_handler('Fraction\Debug\Error::errorHandler');
    set_exception_handler('Fraction\Debug\Error::exceptionHandler');

    $this->router->dispatch();
  }

  public static function bootstrap() {
    $container = Container::getInstance();

    $app = Application::getInstance($container);
    $app->loadComponents();

    return $app;
  }

  public function loadComponents() {
    // a list of components to register
    $components = Yaml::parse(Application::getDirConfig() . '/components.yml');
    // application base dir
    $base_dir = Application::getDirApp();

    $loader = Autoloader::getInstance();
    $loader->register();

    // Including production dependencies
    foreach ($components['production'] as $component_namespace) {
      $loader->addNamespace($component_namespace, $base_dir);
    }

    // Including dev dependencies
    if(Application::$config->get('app.env') == 'dev') {
      foreach ($components['dev'] as $component_namespace) {
        $loader->addNamespace($component_namespace, $base_dir);
      }
    }
  }
}