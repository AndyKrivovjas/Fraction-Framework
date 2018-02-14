<?php
/**
 * Created by andy.
 * Date: 2/14/18
 * Time: 2:35 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\Helper;


class ArrayHelper {

  /**
   * @param $array
   * @param string $key_delimiter
   * @return array
   */
  public static function mulAssocToOneDem(&$array, $key_delimiter = '.') {
    //prime the stack
    $stack = [];
    foreach ($array as $k => &$v) {
      $stack[] = [
        'keyPath' => [$k],
        'node' => &$v
      ];
    }

    $lookup = [];

    while ($stack) {
      $frame = array_pop($stack);
      if (self::isAssoc($frame['node'])) {
        foreach ($frame['node'] as $key => &$node) {
          $keyPath = array_merge($frame['keyPath'], array($key));
          $stack[] = array(
            'keyPath' => $keyPath,
            'node' => &$node
          );

        }
      } else {
        $lookup[join($key_delimiter, $frame['keyPath'])] = &$frame['node'];
      }
    }

    return $lookup;
  }

  /**
   * @param $array
   * @return bool
   */
  public static function isAssoc($array) {
    if(!is_array($array)) return false;
    if (array() === $array) return false;
    return array_keys($array) !== range(0, count($array) - 1);
  }

}