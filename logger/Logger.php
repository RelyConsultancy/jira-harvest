<?php
/**
 * This file is part of the logger package.
 *
 * (c) Freshbyte Inc <http://freshbyteinc.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace logger;

/**
 * Class Logger
 * @package logger
 */
class Logger
{
  /**
   * @var string
   */
  protected static $infoLogFilePath = '../logs/infoLog.csv';

  /**
   * @var string
   */
  protected static $errorLogFilePath = '../logs/errorLog.csv';

  /**
   * Logger method.
   *
   * @param string $method
   * @param string $message
   * @param mixed $extraData
   * @param string $type
   */
  public static function log($method, $message, $extraData = '', $type = 'INFO')
  {
    $file = self::$infoLogFilePath;

    if ('INFO' != $type)
    {
      $file = self::$errorLogFilePath;
    }

    // Create the directory for the logs if this was not created.
    $dirName = dirname($file);
    if (!is_dir($dirName))
    {
      mkdir($dirName, 0755, TRUE);
    }

    $data = array(time(), $method, $message);
    $data[] = (is_string($extraData) || is_numeric($extraData)) ? $extraData : json_encode($extraData);

    $handle = fopen($file, "a");
    fputcsv($handle, $data);
    fclose($handle);
  }
}
