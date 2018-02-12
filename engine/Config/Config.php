<?php
/**
 * Created by andy.
 * Date: 2/12/18
 * Time: 7:47 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\Fraction\Config;


use Fraction\Yaml\Yaml;

class Config {
  private $data = [];

  public function __construct() {
    $params = Yaml::parse(DIR_CONFIG . '/parameters.yml');

    $patterns = array_map(function($item) {
      return '/%' . $item . '%/';
    }, array_keys($params['parameters']));

    $replacements = array_values($params['parameters']);

    $this->data = Yaml::parse(DIR_CONFIG . '/config.yml', $patterns, $replacements);
  }

  public function getAll() {
    return $this->data;
  }
}