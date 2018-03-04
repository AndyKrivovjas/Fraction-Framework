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
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

class Logger implements LoggerInterface {
  use LoggerTrait;

  /**
   * Logs with an arbitrary level.
   *
   * @param mixed $level
   * @param string $message
   * @param array $context
   *
   * @return void
   */
  public function log($level, $message, array $context = array()) {
    switch ($level) {
      case LogLevel::INFO:
        $log = Application::getDirLogs('info') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
        ini_set('error_log', $log);
        $message = '[INFO] ' . $message;
        break;
      case LogLevel::NOTICE:
        $log = Application::getDirLogs('notice') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
        ini_set('error_log', $log);
        $message = '[NOTICE] ' . $message;
        break;
      case LogLevel::ERROR:
        $log = Application::getDirLogs('error') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
        ini_set('error_log', $log);
        $message = '[ERROR] ' . $message;
        break;
      default:
        $log = Application::getDirLogs('info') . '/' . date('Y-m-d') . '-' . Application::$config->get('app.env') . '.log';
        ini_set('error_log', $log);
        $message = '[INFO] ' . $message;
    }

    error_log($message);
  }
}