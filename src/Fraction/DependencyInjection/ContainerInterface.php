<?php
/**
 * Created by andy.
 * Date: 3/4/18
 * Time: 11:50 AM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fraction\DependencyInjection;

interface ContainerInterface extends \Psr\Container\ContainerInterface {

  /**
   * Method to bind a concrete class to an abstract class or interface.
   *
   * @param string          $abstract Class to bind.
   * @param \Closure|string $concrete Concrete definition to bind to $abstract.
   *
   * @return Definition|\Closure The concrete class for adding method calls / constructor arguments if desired.
   */
  public function bind($abstract, $concrete = null);

  /**
   * Sets an alias for the server.
   *
   * @param $className
   * @param $alias
   */
  public function setAlias($className, $alias);

  /**
   * Build a concrete instance of a class.
   *
   * @param string $concrete The name of the class to buld.
   *
   * @return mixed The instantiated class.
   * @throws  \InvalidArgumentException
   * @throws \ReflectionException
   */
  public function build($concrete);

  /**
   * Recursively build the dependency list for the provided method.
   *
   * @param \ReflectionMethod $method The method for which to obtain dependencies.
   *
   * @return array An array containing the method dependencies.
   * @throws \InvalidArgumentException
   */
  public function getDependencies(\ReflectionMethod $method);

  /**
   * Get the raw object prior to resolution.
   *
   * @param string $binding The $binding key to get the raw value from.
   *
   * @return Definition|\Closure Value of the $binding.
   */
  public function getRaw($binding);

  /**
   * Resolve the given binding.
   *
   * @param string $binding The binding to resolve.
   *
   * @return mixed The results of invoking the binding callback.
   */
  public function resolve($binding);

  /**
   * Finds an entry of the container by its identifier and returns it.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return mixed Entry.
   */
  public function get($id);

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
  public function has($id);

  /**
   * Determines class name by alias or returns className itself.
   *
   * @param $id
   * @return mixed
   */
   public function getClassNameById($id);
}