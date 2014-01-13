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

            $components = $action == '' ? $components = ['Home', 'index'] : explode('/', $action);

            $controller = '\\' . Application::config('applicationName') . '\\' . array_shift($components) . 'Controller';

            if (class_exists(ucfirst($controller))) {
                Logger::write('>> Controller ' . $controller . ' found!');
                
                $class = new $controller();
                $method = empty($components) ? 'index' : array_shift($components);

                if (method_exists($class, $method)) {
                    Logger::write('>> Method ' . $method . ' found!');
                    Logger::write('>> Executing action "' . $controller .'::' . $method . '"');
                    try {
                        return $class->$method();
                    } catch (\Exception $e) {
                        Logger::write($e);
                        return $e;
                    }
                }
                else {
                    Logger::write('>> Method ' . $method . ' not found!', Logger::WARNING);
                    throw new RouteException(RouteException::METHOD_NOT_FOUND_ERROR, $method);
                }
            }
            else {
                Logger::write('>> Controller ' . $controller . ' not found!', Logger::WARNING);
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