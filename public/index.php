<?php
/**
 * Application entry point
 */
function bootstrap() {
    spl_autoload_register(function($class) {
        $components = explode('\\', $class);

        // Searches for a lib file
        if ($components[0] == 'Gazpacho') {
            $paths = array(
                'core',
                'util',
                'exception'
            );

            foreach ($paths as $path) {
                $filePath = '../lib/' . $path . '/' . $components[1] . '.php';
                if (file_exists($filePath)) {
                    require_once $filePath;
                    break;
                }
            }
        }
        // Searches for an application file
        else {
            $paths = array(
                'controllers',
                'models',
                'helpers'
            );

            foreach ($paths as $path) {
                $filePath = '../app/' . $path . '/' . $components[1] . '.php';
                if (file_exists($filePath)) {
                    require_once $filePath;
                    break;
                }
            }
        }
    });

    if (\Gazpacho\Application::initialization()) {
        echo \Gazpacho\Application::processRequest();
    }

    \Gazpacho\Application::finalization();

    return 0;
}

bootstrap();