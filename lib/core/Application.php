<?php
namespace Gazpacho;

use \Gazpacho\Logger;
use \Gazpacho\Router;
use \Gazpacho\Database;

final class Application
{
    static private $_config;
    static public function config($entry)
    {
        return self::$_config[$entry];
    }

    static private $_database;
    static public function database()
    {
        return self::$_database;
    }

    private function __construct() { }

    static public function initialization()
    {
        Logger::write('Application initializing…');

        Logger::write(':: Reading application config…');
        self::$_config = require '../config/app.php';
        Logger::write(':: Application config loaded correctly!');

        Logger::write(':: Database instantiation…');
        if (self::$_database = new Database()) {
            Logger::write(':: Database instantiated correctly!');
        }
        else {
            Logger::write('xx Database couldn\'t be initilised!');
        }
        Logger::write('Application initialized!');
        return TRUE;
    }

    static public function processRequest()
    {
        Logger::write('Application processing…');
        Logger::write('---------------------------------------------------------------');

        $return = Router::dispatch();

        Logger::write('---------------------------------------------------------------');
        Logger::write('Application process finished succesfully!');
        return $return;
    }

    static public function finalization()
    {
        Logger::write('Application finalizing…');

        self::$_database = NULL;

        Logger::write('Application finalized!');
        return TRUE;
    }
}