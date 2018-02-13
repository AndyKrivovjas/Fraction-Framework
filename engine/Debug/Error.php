<?php
/**
 * Created by andy.
 * Date: 2/13/18
 * Time: 5:57 PM
 *
 * This file is part of the Fraction package.
 *
 * (c) Andy Kryvoviaz <andy.krivovjas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fraction\Debug;


use Exception;

class Error {
  /**
   * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
   *
   * @param int $level Error level
   * @param string $message Error message
   * @param string $file Filename the error was raised in
   * @param int $line Line number in the file
   *
   * @return void
   * @throws \ErrorException
   */
  public static function errorHandler($level, $message, $file, $line) {
    if (error_reporting() !== 0) {  // to keep the @ operator working
      throw new \ErrorException($message, 0, $level, $file, $line);
    }
  }
  /**
   * Exception handler.
   *
   * @param Exception $exception  The exception
   *
   * @return void
   */
  public static function exceptionHandler($exception) {
    global $appConfig;
    // Code is 404 (not found) or 500 (general error)
    $code = $exception->getCode();
    if ($code != 404) {
      $code = 500;
    }

    http_response_code($code);
    if (false) {
      echo "<h1>Fatal error</h1>";
      echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
      echo "<p>Message: '" . $exception->getMessage() . "'</p>";
      echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
      echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
    } else {
      $log = DIR_LOGS . '/' . date('Y-m-d') . '-' . $appConfig->get('framework.environment') . '.log';
      ini_set('error_log', $log);
      $message = "Uncaught exception: '" . get_class($exception) . "'";
      $message .= " with message '" . $exception->getMessage() . "'";
      $message .= "\nStack trace: " . $exception->getTraceAsString();
      $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
      error_log($message);
    }
  }
}