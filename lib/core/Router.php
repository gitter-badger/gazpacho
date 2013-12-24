<?php
namespace Gazpacho;

use \Gazpacho\Logger;
use \Gazpacho\Request;
use \Gazpacho\RouteException;

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
            $controller = empty($components) > 0 ? '\\' . Application::config('applicationName') . '\\' . array_shift($components) . 'Controller' : '\\' . Application::config('applicationName') . '\\' . 'HomeController';

            if (class_exists(ucfirst($controller))) {
                Logger::write('>> Controller ' . $controller . ' found!');
                
                $controller = new $controller();
                $method = empty($components) > 0 ? array_shift($components) : 'index';

                if (method_exists($controller, $method)) {
                    Logger::write('>> Method ' . $method . ' found!');
                    Logger::write('>> Executing action "' . $controller .'::' . $method . '"');
                    return $controller->$method();
                }
                else {
                    Logger::write('>> Method ' . $method . ' not found!');
                    throw new RouteException(RouteException::METHOD_NOT_FOUND_ERROR, $method);
                }
            }
            else {
                Logger::write('>> Controller ' . $controller . ' not found!');
                throw new RouteException(RouteException::CONTROLLER_NOT_FOUND_ERROR, $controller);
            }
        } catch (RouteException $e) {
            $class = '\\' . Application::config('applicationName') . '\\' . 'NotFoundController';
            if (class_exists($class)) {
                $notFoundController = new $class();
                if (method_exists($notFoundController, 'index')) {
                    Logger::write('>> Executing action "' . $class . '::index"');
                    return $notFoundController->index($e->message());
                } else {
                    Logger::write('Existe implementado un "NotFoundController", pero carece de la acción index()… ¡Impleméntala, maldito!', Logger::WARNING);
                }
            } else {
                Logger::write($e->message(), Logger::WARNING);
            }
        }
    }
}