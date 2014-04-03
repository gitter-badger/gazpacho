<?php
namespace Gazpacho;

use \Gazpacho\Application;
use \Gazpacho\Logger;
use \Gazpacho\DatabaseException;

/**
 * A simple PDO wrapper.
 *
 * @property resource $_connection Database PDO connection
 */
final class Database
{
    const FETCH_MODE_ARRAY = 0;
    const FETCH_MODE_JSON = 1;
    const FETCH_MODE_OBJECT = 2;
    const FETCH_MODE_NONE = 3;

    private $_connection;

    /**
     * Class constructor
     *
     * It loads the database configuration file and creates the database
     * connection
     */
    public function __construct()
    {
        $config = require '../config/db.php';

        // Creates the DSN usign both, the application config and the database config just loaded
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

        // Sets the error handling mode to throw exceptions everytime an error is reached
        $this->_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = [], $mode = self::FETCH_MODE_ARRAY)
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
            case self::FETCH_MODE_NONE:
                break;
            default:
                throw new DatabaseException(DatabaseException::UNKNOWN_FETCH_MODE_ERROR);
                break;
        }
    }

    public function __destruct()
    {
        $this->_connection = NULL;
    }
}