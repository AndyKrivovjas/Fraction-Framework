<?php
/**
 * Created by andy.
 * Date: 2/14/18
 * Time: 2:58 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\Logger;


use Fraction\Application;

class Logger {

  public static function error($message) {
    $log = Application::getDirLogs('error') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
    ini_set('error_log', $log);
    $message = '[ERROR] ' . $message;
    error_log($message);
  }

  public static function notice($message) {
    $log = Application::getDirLogs('notice') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
    ini_set('error_log', $log);
    $message = '[NOTICE] ' . $message;
    error_log($message);
  }

  public static function info($message) {
    global $app;

    $log = Application::getDirLogs('info') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
    ini_set('error_log', $log);
    $message = '[INFO] ' . $message;
    error_log($message);
  }

}