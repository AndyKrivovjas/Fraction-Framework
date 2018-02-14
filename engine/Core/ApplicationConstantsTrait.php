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

namespace Fraction\Core;

trait ApplicationConstantsTrait {
  private static $constants = [];

  public static function defineConstants() {
    self::$constants['DIR_ROOT']        = $_SERVER['DOCUMENT_ROOT'];
    self::$constants['DIR_ENGINE']      = self::$constants['DIR_ROOT'] . '/engine';
    self::$constants['DIR_APP']         = self::$constants['DIR_ROOT'] . '/app';
    self::$constants['DIR_CONFIG']      = self::$constants['DIR_ROOT'] . '/config';
    self::$constants['DIR_CACHE']       = self::$constants['DIR_ROOT'] . '/var/cache';
    self::$constants['DIR_LOGS']        = self::$constants['DIR_ROOT'] . '/var/logs';
    self::$constants['DIR_LOGS_ERROR']  = self::$constants['DIR_LOGS'] . '/error';
    self::$constants['DIR_LOGS_NOTICE'] = self::$constants['DIR_LOGS'] . '/notice';
    self::$constants['DIR_LOGS_INFO']   = self::$constants['DIR_LOGS'] . '/info';
  }

  public static function getDirRoot() {
    return self::$constants['DIR_ROOT'];
  }

  public static function getDirEngine() {
    return self::$constants['DIR_ENGINE'];
  }

  public static function getDirApp() {
    return self::$constants['DIR_APP'];
  }

  public static function getDirConfig() {
    return self::$constants['DIR_CONFIG'];
  }

  public static function getDirCache() {
    return self::$constants['DIR_CACHE'];
  }

  public static function getDirLogs($subdir = 'info') {
    if($subdir === 'info') {
      return self::$constants['DIR_LOGS_INFO'];
    }
    if($subdir === 'error') {
      return self::$constants['DIR_LOGS_ERROR'];
    }
    if($subdir === 'notice') {
      return self::$constants['DIR_LOGS_NOTICE'];
    }

  }
}