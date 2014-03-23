<?php
namespace Gazpacho;

use \Gazpacho\Logger;
use \Gazpacho\Router;
use \Gazpacho\Database;

/**
 * This is the main application class.
 * 
 * Remember: THIS IS A PSEUDO-STATIC CLASS
 * The app has three states:
 *   - initialization()
 *   - processRequest()
 *   - finalization()
 * 
 */
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

    /**
     * Initializes the application.
     *
     * Loads the app configuration and instantiates the database
     *
     * @return bool
     */
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
            Logger::write('xx Database couldn\'t be initilised!', Logger::ERROR);
        }
        Logger::write('Application initialized!');
        return TRUE;
    }

    /**
     * Performs the action requested.
     *
     * An action is an object's method. Uses the router to search
     * the correct action and executes it.
     *
     * @return string
     */
    static public function processRequest()
    {
        Logger::write('Application processing…');
        Logger::write('---------------------------------------------------------------');

        $return = Router::dispatch();

        Logger::write('---------------------------------------------------------------');
        Logger::write('Application process finished succesfully!');
        return $return;
    }

    /**
     * Finalizes the application.
     *
     * Destroys the database instance and releases the resources
     *
     * @return bool
     */
    static public function finalization()
    {
        Logger::write('Application finalizing…');

        self::$_database = NULL;

        Logger::write('Application finalized!');
        return TRUE;
    }
}