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

namespace Fraction\Config;


use Fraction\Application;
use Fraction\Helper\ArrayHelper;
use Fraction\Yaml\Yaml;

class Config {
  private $data = [];

  public function __construct() {
    $params = Yaml::parse(Application::getDirConfig() . '/parameters.yml');

    $patterns = array_map(function($item) {
      return '/%' . $item . '%/';
    }, array_keys($params['parameters']));

    $replacements = array_values($params['parameters']);

    $parsed_config = Yaml::parse(Application::getDirConfig() . '/config.yml', $patterns, $replacements);
    $this->data = ArrayHelper::mulAssocToOneDem($parsed_config);
  }

  public function getAll() {
    return $this->data;
  }

  public function get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : false;
  }

  public function set($key, $value) {
    $this->data[$key] = $value;
  }

  private function validateConfig() {

  }
}