<?php
/**
 * Created by andy.
 * Date: 2/12/18
 * Time: 7:15 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\Yaml;


class Yaml {

  public static function parse($filename, $patterns = [], $replacements = []) {
    $string = file_get_contents($filename);

    $new_string = preg_replace($patterns, $replacements, $string);

    return yaml_parse($new_string);
  }

}