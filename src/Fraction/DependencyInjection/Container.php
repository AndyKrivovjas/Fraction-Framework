<?php
/**
 * Created by andy.
 * Date: 3/4/18
 * Time: 11:58 AM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\DependencyInjection;


use Fraction\Application;
use Fraction\Controller\SingletonTrait;
use Fraction\Yaml\Yaml;
use ReflectionClass;

class Container implements ContainerInterface {
  use SingletonTrait;

  protected $compiled = [];
  protected $bindings = [];
  protected $aliases = [];

  private function __construct() {
    $definedServices = Yaml::parse(Application::getDirConfig() . '/services.yml');
    foreach ($definedServices as $alias => $service) {
      $definition = $this->bind($service['class']);
      if(isset($service['callOnMethod'])) {
        $definition->withMethod($service['callOnMethod'], $service['arguments']);
      } else {
        $definition->addArgs($service['arguments']);
      }
      $this->setAlias($service['class'], $alias);
    }
  }

  /**
   * Method to bind a concrete class to an abstract class or interface.
   *
   * @param string          $abstract Class to bind.
   * @param \Closure|string $concrete Concrete definition to bind to $abstract.
   *
   * @return Definition|\Closure The concrete class for adding method calls / constructor arguments if desired.
   */
  public function bind($abstract, $concrete = null) {
    if (is_null($concrete)) {
      $concrete = $abstract;
    }
    if (is_string($concrete)) {
      $concrete = new Definition($this, $concrete);
    }
    $this->bindings[$abstract] = $concrete;
    return $concrete;
  }

  /**
   * Sets an alias for the server.
   *
   * @param $className
   * @param $alias
   */
  public function setAlias($className, $alias) {
    $this->aliases['#' . $alias] = $className;
  }

  /**
   * Build a concrete instance of a class.
   *
   * @param string $concrete The name of the class to buld.
   *
   * @return mixed The instantiated class.
   * @throws  \InvalidArgumentException
   * @throws \ReflectionException
   */
  public function build($concrete) {
    $reflection = new ReflectionClass($concrete);
    if (! $reflection->isInstantiable()) {
      throw new \InvalidArgumentException(sprintf('Class %s is not instantiable.', $concrete));
    }
    $constructor = $reflection->getConstructor();
    if (is_null($constructor)) {
      return new $concrete;
    }

    $dependencies = $this->getDependencies($constructor);
    return $reflection->newInstanceArgs($dependencies);
  }

  /**
   * Recursively build the dependency list for the provided method.
   *
   * @param \ReflectionMethod $method The method for which to obtain dependencies.
   *
   * @return array An array containing the method dependencies.
   * @throws \InvalidArgumentException
   */
  public function getDependencies(\ReflectionMethod $method) {
    $dependencies = array();
    foreach ($method->getParameters() as $param) {
      $dependency = $param->getClass();
      if (is_null($dependency)) {
        if ($param->isOptional()) {
          $dependencies[] = $param->getDefaultValue();
          continue;
        }
      } else {
        $dependencies[] = $this->resolve($dependency->name);
        continue;
      }
      throw new \InvalidArgumentException('Could not resolve ' . $param->getName());
    }
    return $dependencies;
  }

  /**
   * Get the raw object prior to resolution.
   *
   * @param string $binding The $binding key to get the raw value from.
   *
   * @return Definition|\Closure Value of the $binding.
   */
  public function getRaw($binding) {
    if (isset($this->bindings[$binding])) {
      return $this->bindings[$binding];
    }
    return null;
  }

  /**
   * Resolve the given binding.
   *
   * @param string $binding The binding to resolve.
   *
   * @return mixed The results of invoking the binding callback.
   */
  public function resolve($binding) {
    $rawObject = $this->getRaw($binding);
    // If the abstract is not registered, do it now for easy resolution.
    if (is_null($rawObject)) {
      // Pass $binding to both so it doesn't need to check if null again.
      $this->bind($binding, $binding);
      $rawObject = $this->getRaw($binding);
    }
    return $rawObject($this);
  }

  /**
   * Finds an entry of the container by its identifier and returns it.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return mixed Entry.
   */
  public function get($id) {
    $className = $this->getClassNameById($id);
    if(!isset($this->compiled[$id])) {
      $this->compiled[$id] = $this->resolve($className);
    }
    return $this->compiled[$id];
  }

  public function set($id, $className, $arguments = []) {
    $this->bind($className)->addArgs($arguments);
    $this->setAlias($className, $id);
  }

  /**
   * Returns true if the container can return an entry for the given identifier.
   * Returns false otherwise.
   *
   * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
   * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return bool
   */
  public function has($id) {
    $className = $this->getClassNameById($id);
    return isset($this->bindings[$className]);
  }

  /**
   * Determines class name by alias or returns className itself.
   *
   * @param $id
   * @return mixed
   */
  public function getClassNameById($id) {
    if(isset($this->aliases[$id])) {
      return $this->aliases[$id];
    } else {
      return $id;
    }
  }
}