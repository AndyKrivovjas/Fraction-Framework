<?php
/**
 * Created by andy.
 * Date: 3/4/18
 * Time: 1:48 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\Controller;

use Fraction\Debug\Error;

trait SingletonTrait {
  private static $instance = null;

  public static function getInstance(...$args): self {
    if(self::$instance == null) {
      $className = self::class;

      if(empty($args)) {
        self::$instance = new $className();
      } else {
        try {
          $ref = new \ReflectionClass($className);
          $instance = $ref->newInstanceWithoutConstructor();

          $constructor = $ref->getConstructor();
          $constructor->setAccessible(true);
          $constructor->invokeArgs($instance, $args);

          self::$instance = $instance;
        } catch (\ReflectionException $e) {
          Error::displayException($e);
        }
      }
    }

    return self::$instance;
  }
}