<?php
namespace Gazpacho;

use \Gazpacho\Application;
use \Gazpacho\Logger;
use \Gazpacho\DatabaseException;

final class Database
{
    const FETCH_MODE_ARRAY = 0;
    const FETCH_MODE_JSON = 1;
    const FETCH_MODE_OBJECT = 2;

    private $_connection;

    public function __construct()
    {
        $config = require '../config/db.php';

        $dsn = 'mysql:host=' . $config[Application::config('environment')]['host'] . ';port=' . $config[Application::config('environment')]['port'] . ';dbname=' . $config[Application::config('environment')]['database'];

        try {
            $this->_connection = new \PDO(
                $dsn,
                $config[Application::config('environment')]['username'],
                $config[Application::config('environment')]['password'],
                array(\PDO::ATTR_PERSISTENT => FALSE)
            );
        } catch (\PDOException $ex) {
            return FALSE;
        }

        $this->_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = [], $mode = self::FETCH_MODE_ARRAY, $process = TRUE)
    {
        try {
            $res = $this->_connection->prepare($sql);

            if (empty($params)) {
                $res->execute();
            }
            else {
                $res->execute($params);
            }

            if ($res === FALSE) {
                throw new DatabaseException(DatabaseException::QUERY_ERROR);
            }
        } catch (\PDOException $e) {
            throw new DatabaseException(DatabaseException::QUERY_ERROR);
        }

        if ($process) {
            switch ($mode) {
                case self::FETCH_MODE_ARRAY:
                    return $res->fetchAll(\PDO::FETCH_ASSOC);
                    break;
                case self::FETCH_MODE_JSON:
                    return json_encode($res->fetchAll(\PDO::FETCH_ASSOC));
                    break;
                case self::FETCH_MODE_OBJECT:
                    return $res->fetchAll();
                    break;
                default:
                    throw new DatabaseException(DatabaseException::UNKNOWN_FETCH_MODE_ERROR);
                break;
            }
        }
    }

    public function __destruct()
    {
        $this->_connection = NULL;
    }
}