<?php
namespace Gazpacho;

use \Gazpacho\Application;
use \Gazpacho\Logger;

final class Database
{
    private $_connection;

    public function __construct()
    {
        $config = require '../config/db.php';
        $this->_connection = new \PDO(
            'mysql:host=' . $config[Application::config('environment')]['host'] . ';port=' . $config[Application::config('environment')]['port'] . 'dbname=' . $config[Application::config('environment')]['database'],
            $config[Application::config('environment')]['username'],
            $config[Application::config('environment')]['password'],
            array(\PDO::ATTR_PERSISTENT => FALSE));
    }

    public function query($sql)
    {
        $this->_connection->prepare($sql);
    }

    public function __destruct()
    {
        $this->_connection = NULL;
    }
}