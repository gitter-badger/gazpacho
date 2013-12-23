<?php
namespace Gazpacho;

use \Gazpacho\Logger;

final class Database
{
    private $_connection;

    public function __construct()
    {
        $config = require '../config/db.php';
        $this->_connection = new \PDO('mysql:host=' . $config['host'] . ';port=' . $config['port'] . 'dbname=' . $config['database'], $config['username'], $config['password'], array(\PDO::ATTR_PERSISTENT => false));
    }

    public function query($sql)
    {
        $this->_connection->prepare($sql);
    }

    public function __destruct()
    {
        mysql_close($this->_connection);
    }
}