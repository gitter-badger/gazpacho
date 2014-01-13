<?php
namespace Gazpacho;

use \Gazpacho\Application;

final class Logger
{
    const DEBUG = 'debug';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';
    
    static public function write($message = '', $level = Logger::DEBUG)
    {
        $date = date('Ymd');
        $handler = fopen(__DIR__ . '/../../logs/' . $date . '.' . $level, 'a+');

        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }

        fwrite($handler, '[' . date('d/m/Y') . '@' . date('H:i:s') . '] ' . $message . "\r\n");
        fclose($handler);
    }
}