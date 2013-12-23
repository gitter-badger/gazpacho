<?php
namespace Gazpacho;

use \Gazpacho\Logger;
use \Gazpacho\Request;

final class Router
{
    private function __construct() { }

    static public function dispatch()
    {
        Logger::write('Router dispatching request…');

        try {
            $req = new Request();
            $action = $req->parameter('action');

            $components = explode('/', $action);
            $controller = empty($components) > 0 ? array_shift($components) . 'Controller' : 'HomeController';

            if (file_exists($controller)) {
                Logger::write(':: Controller ' . $controller . ' found!');
                
                $controller = new $controller();
                $method = empty($components) > 0 ? array_shift($components) : 'index';

                if (method_exists($controller, $method)) {
                    Logger::write(':: Method ' . $method . ' found!');
                    return $controller->$method();
                }
                else {
                    throw new RouteException(RouteException::METHOD_NOT_FOUND_ERROR, $method);
                }
            }
            else {
                throw new RouteException(RouteException::CONTROLLER_NOT_FOUND_ERROR, $controller);
            }
        } catch (RouteException $e) {
            $notFoundController = new \Gazpacho\NotFoundController();
            return $notFoundController->index();
        }
    }
}